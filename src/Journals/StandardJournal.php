<?php

namespace Scientist\Journals;

use Scientist\Report;
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
     * The experiment report.
     *
     * @var \Scientist\Report
     */
    protected $report;

    /**
     * Dispatch a report to storage.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Report     $report
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Report $report)
    {
        $this->experiment = $experiment;
        $this->report     = $report;
    }

    /**
     * Get the experiment.
     */
    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    /**
     * Get the experiment report.
     */
    public function getReport(): Report
    {
        return $this->report;
    }
}
