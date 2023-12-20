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
     * @var Experiment
     */
    protected $experiment;

    /**
     * The experiment report.
     *
     * @var Report
     */
    protected $report;

    /**
     * Dispatch a report to storage.
     */
    public function report(Experiment $experiment, Report $report): void
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
