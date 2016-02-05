<?php

use Scientist\Report;
use Scientist\Laboratory;
use Scientist\Experiment;
use Scientist\Journals\StandardJournal;

class JournalTest extends PHPUnit_Framework_TestCase
{
    public function test_that_journals_can_be_created()
    {
        $s = new StandardJournal;
    }

    public function test_that_a_journal_can_be_added_to_a_laboratory()
    {
        $lab = new Laboratory;
        $lab->addJournal(new StandardJournal);
        $this->assertEquals([new StandardJournal], $lab->getJournals());
    }

    public function test_that_multiple_journals_can_be_added_to_a_laboratory()
    {
        $lab = new Laboratory;
        $lab->addJournal(new StandardJournal);
        $lab->addJournal(new StandardJournal);
        $this->assertEquals([new StandardJournal, new StandardJournal], $lab->getJournals());
    }

    public function test_that_a_set_of_journals_can_be_assigned_to_a_laboratory()
    {
        $lab = new Laboratory;
        $lab->setJournals([new StandardJournal, new StandardJournal]);
        $this->assertEquals([new StandardJournal, new StandardJournal], $lab->getJournals());
    }

    public function test_that_journal_receives_experiment_information()
    {
        $lab = new Laboratory;
        $journal = new StandardJournal;
        $lab->addJournal($journal);

        $control = function () { return 'foo'; };
        $trial = function () { return 'bar'; };

        $value = $lab->experiment('foo')
            ->control($control)
            ->trial('bar', $trial)
            ->run();

        $this->assertEquals('foo', $value);
        $this->assertInstanceOf(Experiment::class, $journal->getExperiment());
        $this->assertEquals($control, $journal->getExperiment()->getControl());
        $this->assertArrayHasKey('bar', $journal->getExperiment()->getTrials());
        $this->assertEquals($trial, $journal->getExperiment()->getTrial('bar'));
    }

    public function test_that_journal_receives_result_information()
    {
        $lab = new Laboratory;
        $journal = new StandardJournal;
        $lab->addJournal($journal);

        $control = function () { return 'foo'; };
        $trial = function () { return 'bar'; };

        $value = $lab->experiment('foo')
            ->control($control)
            ->trial('bar', $trial)
            ->run();

        $this->assertEquals('foo', $value);
        $this->assertInstanceOf(Report::class, $journal->getReport());
        $this->assertEquals('foo', $journal->getReport()->getName());
        $this->assertEquals('foo', $journal->getReport()->getControl()->getValue());
        $this->assertEquals('bar', $journal->getReport()->getTrial('bar')->getValue());
        $this->assertEquals(false, $journal->getReport()->getTrial('bar')->isMatch());
    }
}
