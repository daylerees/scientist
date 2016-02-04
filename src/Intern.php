<?php

namespace Scientist;

use Exception;
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
     * @return \Scientist\Result
     */
    public function run(Experiment $experiment)
    {
        return new Result(
            $experiment->getName(),
            $control = $this->runControl($experiment),
            $this->runTrials($experiment, $control)
        );
    }

    /**
     * Run the control callback, and record its execution state.
     *
     * @param \Scientist\Experiment $experiment
     *
     * @return \Scientist\Execution
     */
    protected function runControl(Experiment $experiment)
    {
        return $this->executeCallback(
            $experiment->getControl(),
            $experiment->getParams(),
            $experiment->getMatcher()
        );
    }

    /**
     * Run trial callbacks and record their execution state.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Execution  $control
     *
     * @return array
     */
    protected function runTrials(Experiment $experiment, Execution $control)
    {
        $executions = [];

        foreach ($experiment->getTrials() as $name => $trial) {
            $executions[$name] = $this->executeCallback(
                $trial,
                $experiment->getParams(),
                $experiment->getMatcher(),
                $control
            );
        }

        return $executions;
    }

    /**
     * Execute a callback and record an execution.
     *
     * @param callable                    $callable
     * @param array                       $params
     * @param \Scientist\Matchers\Matcher $matcher
     * @param \Scientist\Execution|null   $control
     *
     * @return \Scientist\Execution
     */
    protected function executeCallback(
        callable  $callable,
        array     $params,
        Matcher   $matcher,
        Execution $control = null
    ) {
        /**
         * We'll execute the provided callable between two
         * recorded timestamps, so that we can calculate
         * the execution time of the code.
         */
        $exception = null;
        $before = microtime(true);
        if ($control) {
            try {
                $value = call_user_func_array($callable, $params);
            } catch (Exception $ex) {
                $value = null;
                $exception = $ex;
            }
        } else {
            $value = call_user_func_array($callable, $params);
        }
        $after = microtime(true);

        /**
         * A control value is provided for trail executions.
         */
        $compare = $control ? $control->getValue() : null;

        return new Execution(
            $value,
            $after - $before,
            $matcher->match($value, $compare),
            $exception
        );
    }
}
