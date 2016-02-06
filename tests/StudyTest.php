<?php


use Scientist\Journals\StandardJournal;
use Scientist\Laboratory;
use Scientist\SideEffects\MissingMethod;
use Scientist\SideEffects\MissingProperty;
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

    public function test_study_uncovers_missing_method_side_effects()
    {
        $study = new Study('test', new Laboratory());
        $study->getLaboratory()->addJournal($journal = new StandardJournal());

        $blind = $study
            ->control($control = new ControlAsset)
            ->trial('trial', new TrialAsset)
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
            ->trial('trial', new TrialAsset)
            ->blind();

        $blind->attribute;

        $this->assertInstanceOf(MissingProperty::class, $journal->getReport()->getTrial('trial')->getException());
    }
}
