<?php


use Scientist\Laboratory;
use Scientist\Study;
use Study\ControlAsset;
use Study\TrialAsset;

class StudyTest extends PHPUnit_Framework_TestCase
{
    public function test_study_can_prepare_a_blind()
    {
        $blind = (new Study('study', new Laboratory()))
            ->control($control = new ControlAsset)
            ->trial('trial name', new TrialAsset)
            ->blind();

        $this->assertInstanceOf(ControlAsset::class, $blind);
        $this->assertNotSame($control, $blind);
    }

    public function test_study_aggregates_experiment_reports()
    {
        $this->markTestIncomplete('todo');
    }

    /**
     * @expectedException \Scientist\SideEffects\MissingMethod
     */
    public function test_study_uncovers_missing_method_side_effects()
    {
        $blind = (new Study('study', new Laboratory()))
            ->control($control = new ControlAsset)
            ->trial('trial name', new TrialAsset)
            ->blind();

        $blind->behavior();
    }

    /**
     * @expectedException \Scientist\SideEffects\MissingProperty
     */
    public function test_study_uncovers_missing_property_side_effects()
    {
        $blind = (new Study('study', new Laboratory()))
            ->control($control = new ControlAsset)
            ->trial('trial name', new TrialAsset)
            ->blind();

        $blind->attribute;
    }
}
