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
     * @param Journal[] $journals
     */
    public function setJournals(array $journals = []): self
    {
        $this->journals = [];
        foreach ($journals as $journal) {
            $this->addJournal($journal);
        }

        return $this;
    }

    /**
     * Register a new journal.
     */
    public function addJournal(Journal $journal): self
    {
        $this->journals[] = $journal;

        return $this;
    }

    /**
     * Retrieve registers journals.
     *
     * @return Journal[]
     */
    public function getJournals(): array
    {
        return $this->journals;
    }

    /**
     * Start a new experiment.
     *
     * @return mixed
     */
    public function experiment(string $name)
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
            return $report->getControl()->getValue();
        }

        return call_user_func_array(
            $experiment->getControl(),
            $experiment->getParams()
        );
    }

    /**
     * Run an experiment and return the result.
     */
    public function getReport(Experiment $experiment): Report
    {
        $report = (new Intern)->run($experiment);
        $this->reportToJournals($experiment, $report);

        return $report;
    }

    /**
     * Report experiment result to registered journals.
     */
    protected function reportToJournals(Experiment $experiment, Report $report): void
    {
        foreach ($this->journals as $journal) {
            $journal->report($experiment, $report);
        }
    }
}
