![Scientist](scientist.png)

# Scientist

[![Build Status](https://travis-ci.org/daylerees/scientist.svg?branch=master)](https://travis-ci.org/daylerees/scientist)

PHP experiment library, inspired by Github's own Scientist.

These docs are temp, expect something more substantial soon.

## Installation

Package blah blah.

## Setup

Before you can run your own experiments, you're going to need to setup a Laboratory.

```php
$lab = new \Scientist\Laboratory;
```

Scientists report their findings to journals. If you'd like to report the result of an experiment, then simply register journals with the laboratory.

```php
$lab->addJournal(new DatabaseJournal);
$lab->addJournal(new RedisJournal);
```

Journals extend the `Scientist\Journals\Journal` interface, and contain a `handle()` method that will receive a `Scientist\Result` instance whenever a test is executed.

> **Note:** If using a framework, you'll probably want to register your laboratory within an IoC container. This will allow you to register the journals only once.

## Usage

```php
$value = $laboratory
    ->experiment('EXPERIMENT NAME')
    ->control($callback)
    ->trial('FIRST TRIAL NAME', $firstCallback)
    ->trial('SECOND TRIAL NAME', $secondCallback)
    ->trial('THIRD TRIAL NAME', $thirdCallback)
    ->run();
```

Experiments are given a name, a control callback, and one or more trial scenarios. The value returned to `$value` will always be the result of the callback provided to `control()`.
When the experiment is executed, the control and all trials are executed in sequence. Your trials might contain refactored or more performant variations of your control code. Upon execution, the time to execute, and result value of each callback will be reported to registered journals. You can then tweak your trials until they become a reliable (or better) replica of your control code, before removing the experiment.

## Example

```php
        $string = 'My name is _NAME_.';

        $stringReplacement = function () use ($string) {
            return str_replace('_NAME_', 'Dayle', $string);
        };

        $regexReplacement = function () use ($string) {
            return preg_replace('/\_NAME\_/', 'Dayle', $string);
        };

        $value = $laboratory
            ->experiment('Replace name in a string.')
            ->control($stringReplacement)
            ->trial('Use preg_replace().', $regexReplacement)
            ->run();

        // $value == 'My name is Dayle.'
```

Here we've created an experiment to attempt to replace a `str_replace()` call with `preg_replace()`. It's a simple test, but it could easily be more complicated. Our registered journals will receive a result object containing information about whether or not trials produce the same result as the control, and how they compare in performance. This information could be fed into a datastore / UI to easily browse all active experiments, and improve on old solutions.
