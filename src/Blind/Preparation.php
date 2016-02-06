<?php


namespace Scientist\Blind;


use ReflectionClass;
use ReflectionProperty;
use Scientist\Experiment;
use Scientist\SideEffects\MissingMethod;
use Scientist\SideEffects\MissingProperty;
use Scientist\Study;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Reflection\ClassReflection;

class Preparation
{
    /**
     * @param Study $study
     * @param mixed $control
     * @param mixed[] $trials
     * @param string[] $interfaces that blind should satisfy
     */
    public function prepare(Study $study, $control, array $trials, array $interfaces = [])
    {
        $experiments = $this->createExperiments($study, $control, $trials);
        return $this->createBlind($study, $control, $experiments);
    }

    private function createBlind($study, array $experiments, array $interfaces = [])
    {
        $blind_name = sprintf("Blind_%s", str_replace('.', '', uniqid('', true)));

        $generator = new ClassGenerator($blind_name, 'Scientist\Blind');
        $generator->setImplementedInterfaces($interfaces);
        $generator->addUse(DecoratorTrait::class);

        $this->getMethodImplementations($generator, $interfaces);

        eval($generator->generate());

        $class_name = sprintf('Scientist\Blind\%s', $blind_name);
        return new $class_name($study, $experiments);
    }

    /**
     * @param $study
     * @param $control
     * @param array $trials
     * @return array
     */
    private function createExperiments(Study $study, $control, array $trials)
    {
        $experiments = [];
        $reflection = new ReflectionClass($control);
        foreach($reflection->getMethods() as $method) {
            $experiments[] = $this->createMethodExperiment($method->getName(), $study, $control, $trials);
        }
        foreach($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $experiments[] = $this->createPropertyExperiment($property->getName(), $study, $control, $trials);
        }
        return $experiments;
    }

    /**
     * @param string $name
     * @param Study $study
     * @param mixed $control
     * @param mixed[] $trials
     * @return Experiment
     */
    private function createMethodExperiment($name, Study $study, $control, array $trials)
    {
        $experiment_name = sprintf('%s::%s', $study->getName(), $name);
        /** @var Experiment $experiment */
        $experiment = $study->getLaboratory()
            ->experiment($experiment_name);

        $experiment->control([$control, $name]);

        foreach($trials as $trial_name => $trial) {
            if(method_exists($trial, $name)){
                $experiment->trial($trial_name, [$trial, $name]);
            } else {
                $experiment->trial($trial_name, $this->createMissingMethodCallable($trial, $name));
            }
        }

        $experiment->matcher($study->getMatcher());
        $experiment->chance($study->getChance());
        $study->addExperiment($experiment);
        return $experiment;
    }

    private function createPropertyExperiment($name, Study $study, $control, array $trials)
    {
        $experiment_name = sprintf('%s::$%s', $study->getName(), $name);
        /** @var Experiment $experiment */
        $experiment = $study->getLaboratory()
            ->experiment($experiment_name);

        $experiment->control($this->createPropertyCallable($control, $name));

        foreach($trials as $trial_name => $trial) {
            if(property_exists($trial, $name)){
                $experiment->trial($trial_name, $this->createPropertyCallable($trial, $name));
            } else {
                $experiment->trial($trial_name, $this->createMissingPropertyCallable($trial, $name));
            }
        }

        $experiment->matcher($study->getMatcher());
        $experiment->chance($study->getChance());
        $study->addExperiment($experiment);
        return $experiment;
    }

    /**
     * @param mixed $instance
     * @param string $name
     * @return callable
     */
    private function createPropertyCallable($instance, $name)
    {
        return function() use ($instance, $name) {
            $args = func_get_args();
            // __set
            if(count($args) > 1) {
                list($name, $value) = $args;
                return $instance->{$name} = $value;
            }
            // __get
            $name = $args[0];
            return $instance->{$name};
        };
    }

    private function createMissingPropertyCallable($instance, $name)
    {
        return function() use ($instance, $name) {
            throw new MissingProperty($instance, $name);
        };
    }

    private function createMissingMethodCallable($instance, $name)
    {
        return function() use ($instance, $name) {
            throw new MissingMethod($instance, $name);
        };
    }

    private function getMethodImplementations(Classgenerator $classGenerator, array $interfaces)
    {
        $template = <<<'PHP'
    $arguments = func_get_args();
    $experiment = $this->getExperiment($this->getExperimentNameForMethod('%s'));
    return call_user_func_array([$experiment, 'run'], $arguments);
PHP;

        foreach($interfaces as $interface) {
            $reflection = new ClassReflection($interface);
            foreach($reflection->getMethods() as $method) {
                $generator = MethodGenerator::fromReflection($method);
                $generator->setBody(sprintf($template, $method->getName()));
                $classGenerator->addMethodFromGenerator($generator);
            }
        }
    }

}