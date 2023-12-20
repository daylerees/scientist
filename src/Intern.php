<?php
declare(strict_types=1);

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
     */
    public function run(Experiment $experiment): Report
    {
        $control = $this->runControl($experiment);
        $trials  = $this->runTrials($experiment);

        $this->determineMatches($experiment->getMatcher(), $control, $trials);

        return new Report($experiment->getName(), $control, $trials);
    }

    /**
     * Run the control callback, and record its execution state.
     */
    protected function runControl(Experiment $experiment): Result
    {
        return (new Machine(
            $experiment->getControl(),
            $experiment->getParams(),
            false,
            $experiment->getControlContext()
        ))->execute();
    }

    /**
     * Run trial callbacks and record their execution state.
     *
     * @return Result[]
     */
    protected function runTrials(Experiment $experiment): array
    {
        $executions = [];

        foreach ($experiment->getTrials() as $name => $trial) {
            $executions[$name] = (new Machine(
                $trial->getCallback(),
                $experiment->getParams(),
                true,
                $trial->getContext()
            ))->execute();
        }

        return $executions;
    }

    /**
     * Determine whether trial results match the control.
     *
     * @param Result[] $trials
     */
    protected function determineMatches(Matcher $matcher, Result $control, array $trials = []): void
    {
        foreach ($trials as $trial) {
            if ($matcher->match($control->getValue(), $trial->getValue())) {
                $trial->setMatch(true);
            }
        }
    }
}
