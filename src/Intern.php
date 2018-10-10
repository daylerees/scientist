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
        $argParams = $experiment->getParams();

        if (!empty($experiment->getControlArguments())) {
            $argParams = $experiment->getControlArguments();
        }

        return (new Machine(
            $experiment->getControl(),
            $argParams,
            false,
            $experiment->getControlContext()
        ))->execute();
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
            $trialArgs = $experiment->getParams();

            if (!empty($trial->getArguments())) {
                $trialArgs = $trial->getArguments();
            }

            $executions[$name] = (new Machine(
                $trial->getCallback(),
                $trialArgs,
                true,
                $trial->getContext()
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
