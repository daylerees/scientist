<?php

namespace Scientist\Journals;

use Scientist\Result;
use Scientist\Experiment;

/**
 * Class StandardJournal
 *
 * @package \Scientist\Journals
 */
class StandardJournal implements Journal
{
    /**
     * The executed experiment.
     *
     * @var \Scientist\Experiment
     */
    protected $experiment;

    /**
     * The experiment result.
     *
     * @var \Scientist\Result
     */
    protected $result;

    /**
     * Dispatch a report to storage.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Result     $result
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Result $result)
    {
        $this->experiment = $experiment;
        $this->result     = $result;
    }

    /**
     * Get the experiment.
     *
     * @return \Scientist\Experiment
     */
    public function getExperiment()
    {
        return $this->experiment;
    }

    /**
     * Get the result.
     *
     * @return \Scientist\Result
     */
    public function getResult()
    {
        return $this->result;
    }
}
