<?php


use Blind\BehaviorAsset;
use Scientist\Blind;
use Scientist\Experiment;
use Scientist\Journals\StandardJournal;
use Scientist\Laboratory;
use Scientist\Matchers\StandardMatcher;
use Scientist\SideEffects\MissingMethod;
use Scientist\SideEffects\MissingProperty;
use Scientist\Study;
use Study\ControlAsset;
use Study\SideEffectTrialAsset;
use Study\TrialAsset;
use Study\UnsafeTrialAsset;

class StudyTest extends PHPUnit_Framework_TestCase
{
    public function test_study_can_prepare_a_blind()
    {
        $blind = (new Study('study', new Laboratory()))
            ->control($control = new ControlAsset)
            ->trial('trial', new TrialAsset)
            ->blind();

        $this->assertInstanceOf(Blind::class, $blind);
        $this->assertNotSame($control, $blind);
    }

    public function test_study_can_prepare_a_blind_that_satisfies_interfaces()
    {
        $blind = (new Study('study', new Laboratory()))
            ->control($control = new ControlAsset)
            ->trial('trial', new TrialAsset)
            ->blind(BehaviorAsset::class, Iterator::class);

        $this->assertInstanceOf(Blind::class, $blind);
        $this->assertInstanceOf(BehaviorAsset::class, $blind);
        $this->assertInstanceOf(Iterator::class, $blind);
        $this->assertNotSame($control, $blind);
    }

    public function test_study_shows_trial_is_safe()
    {
        $study = new Study('test', new Laboratory());
        $study->getLaboratory()->addJournal($journal = new StandardJournal());
        $blind = $study
            ->control($control = new ControlAsset)
            ->trial('trial', new TrialAsset())
            ->blind(BehaviorAsset::class, Iterator::class);

        $blind->behavior();
        $this->assertTrue($journal->getReport()->getTrial('trial')->isMatch());
        $blind->attribute = 'foo';
        $this->assertTrue($journal->getReport()->getTrial('trial')->isMatch());
    }

    public function test_study_shows_trial_is_unsafe()
    {
        $study = new Study('test', new Laboratory());
        $study->getLaboratory()->addJournal($journal = new StandardJournal());
        $blind = $study
            ->control($control = new ControlAsset)
            ->trial('trial', new UnsafeTrialAsset())
            ->blind(BehaviorAsset::class, Iterator::class);

        $blind->behavior();
        $this->assertFalse($journal->getReport()->getTrial('trial')->isMatch());
        $blind->attribute = 'foo';
        $this->assertFalse($journal->getReport()->getTrial('trial')->isMatch());
    }

    public function test_study_uncovers_missing_method_side_effects()
    {
        $study = new Study('test', new Laboratory());
        $study->getLaboratory()->addJournal($journal = new StandardJournal());

        $blind = $study
            ->control($control = new ControlAsset)
            ->trial('trial', new SideEffectTrialAsset())
            ->blind();

        $blind->behavior();

        $this->assertInstanceOf(MissingMethod::class, $journal->getReport()->getTrial('trial')->getException());
    }

    public function test_study_uncovers_missing_property_side_effects()
    {
        $study = new Study('test', new Laboratory());
        $study->getLaboratory()->addJournal($journal = new StandardJournal());

        $blind = $study
            ->control($control = new ControlAsset)
            ->trial('trial', new SideEffectTrialAsset)
            ->blind();

        $blind->attribute;

        $this->assertInstanceOf(MissingProperty::class, $journal->getReport()->getTrial('trial')->getException());
    }

    public function test_that_a_change_variable_can_be_set()
    {
        $study = new Study('test');
        $study->setChance(3);
        $this->assertEquals(3, $study->getChance());
    }

    public function test_that_a_laboratory_can_be_set()
    {
        $study = new Study('test');
        $study->setLaboratory($l = new Laboratory());
        $this->assertSame($l, $study->getLaboratory());
    }

    public function test_that_a_matcher_can_be_set()
    {
        $study = new Study('test');
        $study->setMatcher($m = new StandardMatcher());
        $this->assertSame($m, $study->getMatcher());
    }

    public function test_that_a_name_can_be_set()
    {
        $study = new Study('test');
        $this->assertEquals('test', $study->getName());
    }

    public function test_that_an_experiment_can_be_added()
    {
        $study = new Study('test');
        $e = new Experiment('experiment', new Laboratory());
        $study->addExperiment($e);
        $this->assertSame($e, $study->getExperiment('experiment'));
        $this->assertEquals(['experiment' => $e], $study->getExperiments());
    }

    public function test_that_a_trial_can_be_added()
    {
        $study = new Study('test');
        $trial = function(){};
        $study->trial('trial', $trial);
        $this->assertSame($trial, $study->getTrial('trial'));
        $this->assertEquals(['trial' => $trial], $study->getTrials());
    }
}
