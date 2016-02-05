[![Scientist](scientist.png)](https://packagist.org/packages/daylerees/scientist)

# Scientist

[![Build Status](https://travis-ci.org/daylerees/scientist.svg?branch=master)](https://travis-ci.org/daylerees/scientist)
[![Packagist Version](https://img.shields.io/packagist/v/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)
[![HHVM Tested](https://img.shields.io/hhvm/daylerees/scientist.svg)](https://travis-ci.org/daylerees/scientist)
[![Packagist](https://img.shields.io/packagist/dt/daylerees/scientist.svg)](https://packagist.org/packages/daylerees/scientist)

A PHP experiment library inspired by Github's own [Scientist](https://github.com/github/scientist).

---

- [Install](#installation)
- [Setup](#setup)
- [Usage](#usage)
- [Example](#example)
- [Parameters](#parameters)
- [Chance](#chance-it)
- [Journals](#journals)
- [Matchers](#matchers)

---


## Installation

Require the latest version of Scientist using [Composer](https://getcomposer.org/).

    composer require daylerees/scientist

## Setup

Before you can run your own experiments, you're going to need a Laboratory.

```php
$laboratory = new \Scientist\Laboratory;
```

Scientists report their findings to journals. If you'd like to report the result of an experiment, then simply register journals with the laboratory.

```php
$laboratory->addJournal(new DatabaseJournal);
$laboratory->addJournal(new RedisJournal);
```

Journals extend the `Scientist\Journals\Journal` interface, and contain a `handle()` method that will receive a wealth information whenever an experiment is executed.

> **Note:** If using a framework, you'll probably want to register your laboratory within an IoC container. This will allow you to register the journals only once.

## Usage

```php
$value = $laboratory
    ->experiment(EXPERIMENT_NAME)
    ->control(CONTROL_CALLBACK)
    ->trial(FIRST_TRIAL_NAME, FIRST_TRIAL_CALLBACK)
    ->trial(SECOND_TRIAL_NAME, SECOND_TRIAL_CALLBACK)
    ->run();
```

Still looking for more information? Okay, let's step through this.

```php
$laboratory->experiment('string here');
```

Here we can set the name of our experiment.

```php
$laboratory->control($callable);
```

Here we set our 'control' callback. This should be your current code wrapped in a `callable`.

```php
$laboratory->trial('string here', $callable);
```

Next, we define our trial code. The first parameter gives a useful name to the trial, and the second parameter is another `callable`. The idea is that the callable in this section should be equivalent (or better!) to our control callback. You can add as many trials as you like.

```php
$laboratory->run();
```

The `run()` method will execute our experiment, and return the result of the control callback. It will **never** return a value from a trial. If we'd just like to examine the result of the experiment, we could use `->result()` instead! Neat, right?

## Example

Imagine for a moment that we have a simple piece of code to announce ourselves, and our name. We're using `str_replace()` to insert the name at the moment. Do you think using `preg_replace()` might be better? It would be great to find out, wouldn't it? Let's run an experiment.

```php
// Our announcement template.
$string = 'My name is _NAME_.';

// Callback containing the current (control) code.
$stringReplacement = function () use ($string) {
    return str_replace('_NAME_', 'Dayle', $string);
};

// Callback containing our experimental (trial) code.
$regexReplacement = function () use ($string) {
    return preg_replace('/\_NAME\_/', 'Dayle', $string);
};

// Let's define the experiment.
$value = $laboratory
    ->experiment('Replace name in a string.')
    ->control($stringReplacement)
    ->trial('Use preg_replace().', $regexReplacement)
    ->run();

// $value == 'My name is Dayle.'
```

Upon running the code above, the control and trials are all executed. Using Journals (check the docs!), the results of the tests, and the differences between the control and trials are recorded to a data store for us to examine later. When running the experiment, only the **control** output is returned. We don't want to risk our experiments until we've checked the data.

Once we've checked our data, and we're confident that our trial is equivalent (or better!) to our control code, we'll replace the experiment with that implementation.

## Parameters

Your code might not be useful without additional parameters. Don't worry, we've got you covered.

```php
->run($param, $secondParam, $more);
```

or

```php
->result($param, $secondParam, $more);
```

You can pass parameters to the `run()` or `result()` methods, and the parameters will be provided to both the control and trial callbacks on execution. Simple, right?

## Chance it!

Your experiments might be a little weighty. You might not want to run them all the time. Provide a % chance parameter to alter the chance that an experiment will run.

```php
$laboratory->experiment('foo')
    ->chance(50)...;
```

## Journals

Journals are assigned to a Laboratory, and are used to report on the result of experiments. You'll (hopefully soon) find a bunch of journals on packagist, or you can create your own.

```php
<?php

namespace MyApp;

use Scientist\Result;
use Scientist\Experiment;
use Scientist\Journals\Journal;

class MyJournal implements Journal
{
    /**
     * Dispatch a report to storage.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Result     $result
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Result $result)
    {
        // Store this information in a data store.
    }
```

We could examine the experiment and its result, and export this information to a data store or a log. You have complete freedom with the information that Scientist provides to you. To use a Journal (or multiple journals), simply add them to the Laboratory.

```php
$laboratory->addJournal(new \MyApp\MyJournal);
```

## Matchers

Matchers are used to determine whether a control and trial match. The default matcher will do a strict `===` comparison on the outputs of both callables.

However, you're free to create your own matcher...

```php
<?php

namespace MyApp;

use Scientist\Matchers\Matcher;

class MyMatcher implements Matcher
{
    /**
     * Determine whether two values match.
     *
     * @param mixed $control
     * @param mixed $trial
     *
     * @return boolean
     */
    public function match($control, $trial)
    {
        return $control->name == $trial->name;
    }
}
```

...then we can assign our matcher to the experiment.

```php
$value = $laboratory
    ->experiment('Experiment title')
    ->control($control)
    ->trial('Trial title', $trial)
    ->matcher(new MyApp\MyMatcher)
    ->run();
```

## Additional Documentation

Is coming soon, along with a contribution guide.
