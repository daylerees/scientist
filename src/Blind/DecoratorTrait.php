<?php


namespace Scientist\Blind;


use Scientist\Experiment;
use Scientist\Study;

trait DecoratorTrait
{
    /** @var  Study */
    private $study;
    /** @var Experiment[] */
    private $experiments = [];

    /**
     * @param string $method
     * @return string
     */
    private function getExperimentNameForMethod($method)
    {
        return sprintf("%s::%s", $this->study->getName(), $method);
    }

    /**
     * @param string $attribute
     * @return string
     */
    private function getExperimentNameForAttribute($attribute)
    {
        return sprintf("%s::\$%s", $this->study->getName(), $attribute);
    }

    /**
     * @param string $name
     * @return Experiment
     */
    private function getExperiment($name) {
        return $this->experiments[$name];
    }

    /**
     * DecoratorTrait constructor.
     * @param Study $study
     * @param Experiment[] $experiments
     */
    function __construct(Study $study, array $experiments = [])
    {
        $this->study = $study;
        foreach($experiments as $experiment) {
            $this->experiments[$experiment->getName()] = $experiment;
        }
    }

    function __call($name, $arguments)
    {
        $experiment = $this->getExperiment($this->getExperimentNameForMethod($name));
        return call_user_func_array([$experiment, 'run'], $arguments);
    }

    function __get($name)
    {
        $experiment = $this->getExperiment($this->getExperimentNameForAttribute($name));
        return call_user_func_array([$experiment, 'run'], [$name]);
    }

    function __set($name, $value)
    {
        $experiment = $this->getExperiment($this->getExperimentNameForAttribute($name));
        return call_user_func_array([$experiment, 'run'], [$name, $value]);
    }

    function __isset($name)
    {
        $value = $this->__get($name);
        return $value !== null;
    }

    function __unset($name)
    {
        $this->__set($name, null);
    }

    function __toString()
    {
        $experiment = $this->getExperiment($this->getExperimentNameForMethod('__toString'));
        return call_user_func([$experiment, 'run']);
    }

    function __invoke()
    {
        $arguments = func_get_args();
        $experiment = $this->getExperiment($this->getExperimentNameForMethod('__invoke'));
        return call_user_func_array([$experiment, 'run'], $arguments);
    }
}