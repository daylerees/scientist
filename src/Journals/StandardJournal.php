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
     *
     * @return \Scientist\Experiment
     */
    public function getExperiment()
    {
        return $this->experiment;
    }

    /**
     * Get the experiment report.
     *
     * @return \Scientist\Report
     */
    public function getReport()
    {
        return $this->report;
    }
}
