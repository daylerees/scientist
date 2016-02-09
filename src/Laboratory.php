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
     * @var \Scientist\Journals\Journal[]
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
        $this->journals = [];
        foreach ($journals as $journal) {
            $this->addJournal($journal);
        }

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
        return (new Experiment($name, $this));
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
            $report = $this->getReport($experiment);
            if (is_array($report)) {
                $values = [];
                foreach ($report as $item) {
                    $values[] = $item->getControl()->getValue();
                }

                return implode(',', $values);
            } else {
                return $report->getControl()->getValue();
            }
        }

        return call_user_func_array(
            $experiment->getControl(),
            $experiment->getParams()
        );
    }

    /**
     * Run an experiment and return the result.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Report
     */
    public function getReport(Experiment $experiment)
    {
        $report = (new Intern)->run($experiment);
        $this->reportToJournals($experiment, $report);

        return $report;
    }

    /**
     * Report experiment result to registered journals.
     *
     * @param \Scientist\Experiment   $experiment
     * @param \Scientist\Report|array $report
     *
     * @return void
     */
    protected function reportToJournals(Experiment $experiment, $report)
    {
        foreach ($this->journals as $journal) {
            if (is_array($report)) {
                foreach ($report as $item) {
                    $journal->report($experiment, $item);
                }
            } else {
                $journal->report($experiment, $report);
            }
        }
    }
}
