<?php

namespace Scientist;

use Scientist\Journals\Journal;

/**
 * Class Laboratory
 *
 * The Laboratory is where the magic takes place. Here we define
 * and conduct our experiments.
 *
 * @package \Scientist
 */
class Laboratory
{
    /**
     * Collection of journals to report to.
     *
     * @var array
     */
    protected $journals = [];

    /**
     * Register a collection of journals.
     *
     * @param array $journals
     *
     * @return $this
     */
    public function setJournals(array $journals = [])
    {
        $this->journals = $journals;

        return $this;
    }

    /**
     * Register a new journal.
     *
     * @param \Scientist\Journals\Journal $journal
     *
     * @return $this
     */
    public function addJournal(Journal $journal)
    {
        $this->journals[] = $journal;

        return $this;
    }

    /**
     * Retrieve registers journals.
     *
     * @return array
     */
    public function getJournals()
    {
        return $this->journals;
    }

    /**
     * Start a new experiment.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function experiment($name)
    {
        return (new Experiment($name))->setLaboratory($this);
    }

    /**
     * Run an experiment.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return mixed
     */
    public function runExperiment(Experiment $experiment)
    {
        if ($experiment->shouldRun()) {
            $result = $this->getResult($experiment);
            return $result->control()->getValue();
        } else {
            return call_user_func($experiment->getControl());
        }
    }

    /**
     * Run an experiment and return the result.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Result
     */
    public function getResult(Experiment $experiment)
    {
        $result = (new Intern)->run($experiment);
        $this->reportToJournals($experiment, $result);
        return $result;
    }

    /**
     * Report experiment result to registered journals.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Result     $result
     *
     * @return void
     */
    protected function reportToJournals(Experiment $experiment, Result $result)
    {
        foreach ($this->journals as $journal) {
            $journal->report($experiment, $result);
        }
    }
}
