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
     * @return \Scientist\Report|\Scientist\Report[]
     */
    public function run(Experiment $experiment)
    {
        $control = $this->runControl($experiment);
        $trials  = $this->runTrials($experiment);

        if (is_array($control)) {
            $reports = [];
            foreach ($control as $key => $control_item) {
                $this->determineMatches(
                    $experiment->getMatcher(),
                    $control_item,
                    $trials,
                    $key
                );

                $reports[] = new Report($experiment->getName(), $control_item, $trials);
            }

            return $reports;
        } else {
            $this->determineMatches($experiment->getMatcher(), $control, $trials);

            return new Report($experiment->getName(), $control, $trials);
        }
    }

    /**
     * Run the control callback, and record its execution state.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Result|\Scientist\Result[]
     */
    protected function runControl(Experiment $experiment)
    {
        if (count($experiment->getParams())
            === count($experiment->getParams(), COUNT_RECURSIVE)) {
            return (new Machine(
                $experiment->getControl(),
                $experiment->getParams()
            ))->execute();
        } else {
            $executions = [];

            foreach ($experiment->getParams()[0] as $individual_params) {
                $executions[] = (new Machine(
                    $experiment->getControl(),
                    $individual_params
                ))->execute();
            }

            return $executions;
        }
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
            if (count($experiment->getParams())
                === count($experiment->getParams(), COUNT_RECURSIVE)) {
                $executions[$name] = (new Machine(
                    $trial,
                    $experiment->getParams(),
                    true
                ))->execute();
            } else {
                foreach ($experiment->getParams()[0] as $individual_params) {
                    $executions[$name][] = (new Machine(
                        $trial,
                        $individual_params,
                        true
                    ))->execute();
                }
            }

        }

        return $executions;
    }

    /**
     * Determine whether trial results match the control.
     *
     * @param \Scientist\Matchers\Matcher $matcher
     * @param \Scientist\Result           $control
     * @param \Scientist\Result[]         $trials
     * @param int|null                    $key
     */
    protected function determineMatches(
        Matcher $matcher,
        Result $control,
        array $trials = [],
        $key = null
    ) {
        foreach ($trials as $trial) {
            if ($key !== null) {
                if ($matcher->match($control->getValue(), $trial[$key]->getValue())) {
                    $trial[$key]->setMatch(true);
                }
            } else {
                if ($matcher->match($control->getValue(), $trial->getValue())) {
                    $trial->setMatch(true);
                }
            }
        }
    }
}
