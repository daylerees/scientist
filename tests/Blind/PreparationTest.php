<?php


use Scientist\Blind\DecoratorTrait;
use Scientist\Blind\Preparation;
use Scientist\Experiment;
use Scientist\Laboratory;
use Scientist\Study;
use Study\ControlAsset;
use Study\TrialAsset;

class PreparationTest extends PHPUnit_Framework_TestCase
{
    public function test_preparation_creates_experiments_for_public_methods()
    {
        $preparation = new Preparation();
        $preparation->prepare($study = new Study('test', new Laboratory()), new ControlAsset, [new TrialAsset]);

        $this->assertInstanceOf(Experiment::class, $study->getExperiment('test::behavior'));
    }

    public function test_preparation_creates_experiments_for_public_attributes()
    {
        $preparation = new Preparation();
        $preparation->prepare($study = new Study('test', new Laboratory()), new ControlAsset, [new TrialAsset]);

        $this->assertInstanceOf(Experiment::class, $study->getExperiment('test::$attribute'));
    }

    public function test_preparation_decorates_experiments_in_a_control_extension()
    {
        $preparation = new Preparation();
        $blind = $preparation->prepare($study = new Study('test', new Laboratory()), new ControlAsset, [new TrialAsset]);

        $this->assertInstanceOf(ControlAsset::class, $blind);

        $reflection = new ReflectionClass($blind);
        $this->assertTrue(in_array(DecoratorTrait::class, $reflection->getTraitNames()));
    }
}
