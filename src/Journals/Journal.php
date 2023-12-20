<?php
declare(strict_types=1);

namespace Scientist\Journals;

use Scientist\Report;
use Scientist\Experiment;

/**
 * Class Journal
 *
 * Journals allow the scientist to record experiment results in a
 * variety of different ways.
 *
 * @package \Scientist
 */
interface Journal
{
    /**
     * Dispatch a report to storage.
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Report $report);
}
