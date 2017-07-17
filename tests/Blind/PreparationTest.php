<?php


use Blind\BehaviorAsset;
use Scientist\Blind;
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

    public function test_preparation_returns_a_blind()
    {
        $preparation = new Preparation();
        $blind = $preparation->prepare($study = new Study('test', new Laboratory()), new ControlAsset, [new TrialAsset]);

        $this->assertInstanceOf(Blind::class, $blind);
    }

    public function test_preparation_returns_a_blind_that_implements_interfaces()
    {
        $preparation = new Preparation();
        $blind = $preparation->prepare($study = new Study('test',
            new Laboratory()),
            new ControlAsset,
            [new TrialAsset],
            [BehaviorAsset::class]);

        $this->assertInstanceOf(BehaviorAsset::class, $blind);
    }
}
