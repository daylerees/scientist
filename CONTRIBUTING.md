# Contribution Guide

This guide will be updated with more thorough content, but for now, the best thing you could do to help the project is to create `Journal` packages.

Journals are used to export the information from experiments to data stores for later inspection. They implement the `Scientist\Journals\Journal` interface:

```php
<?php

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
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Report     $report
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Report $report);
}

```

When you implement the `report()` method, the registered Journal will receive an instance of the experiment, and the report from the executed experiment. You can interrogate these instances for all kinds of useful information, and ship that information to a data storage platform.

Here's some useful methods:

```php
$report->getName();        // Get the experiment name. (string)
$report->getControl();     // Get the Scientist\Result instance for the control. (Scientist\Result)
$report->getTrial('name'); // Get the result instance for a trial by name. (Scientist\Result)
$report->getTrials();      // Get an assoc array of trial result instances (array)
```

And on the result instance:

```php
$result->getValue();        // Get the resulting value of the trial/control callback. (mixed)
$result->isMatch();         // Did the result match the control? Use on trial results. (boolean)
$result->getStartTime();    // Float callable start microtime. (float)
$result->getEndTime();      // Float callable end microtime. (float)
$result->getTime();         // Get the execution microtime. (float)
$result->getStartMemory();  // Get memory usage before calling. (integer)
$result->getEndMemory();    // Get memory usage after calling. (integer)
$result->getMemory();       // Get different in memory usage. (integer)
```

If you create a new journal (and a composer package, format scientist-xxx-journal) then please be sure to raise an issue and let me know! I'll update the docs to mentions it.

Thanks for all your support!

- Dayle.
