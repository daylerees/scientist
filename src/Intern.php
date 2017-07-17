<?php

namespace Scientist;

use Scientist\Matchers\Matcher;

/**
 * Class Intern
 *
 * Interns do all the hard work, naturally. They'll execute an experiment within
 * the Laboratory, and record the results.
 *
 * @package \Scientist
 */
class Intern
{
    /** @var bool  */
    protected $overreact = false;

    /**
     * Exceptions will be thrown from experiments
     */
    public function overreact()
    {
        $this->overreact = true;
    }

    /**
     * Run an experiment, and retrieve the result.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Report
     */
    public function run(Experiment $experiment)
    {
        $control = $this->runControl($experiment);
        $trials  = $this->runTrials($experiment);

        $this->determineMatches($experiment->getMatcher(), $control, $trials);

        return new Report($experiment->getName(), $control, $trials);
    }

    /**
     * Run the control callback, and record its execution state.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Result
     */
    protected function runControl(Experiment $experiment)
    {
        return (new Machine($experiment->getControl(), $experiment->getParams()))->execute();
    }

    /**
     * Run trial callbacks and record their execution state.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Result[]
     */
    protected function runTrials(Experiment $experiment)
    {
        $executions = [];

        foreach ($experiment->getTrials() as $name => $trial) {
            $executions[$name] = (new Machine(
                $trial,
                $experiment->getParams(),
                (! $this->overreact)
            ))->execute();
        }

        return $executions;
    }

    /**
     * Determine whether trial results match the control.
     *
     * @param \Scientist\Matchers\Matcher $matcher
     * @param \Scientist\Result           $control
     * @param \Scientist\Result[]         $trials
     */
    protected function determineMatches(Matcher $matcher, Result $control, array $trials = [])
    {
        foreach ($trials as $trial) {
            if ($matcher->match($control->getValue(), $trial->getValue())) {
                $trial->setMatch(true);
            }
        }
    }
}
