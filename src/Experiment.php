<?php

namespace Scientist;

use Scientist\Report;
use Scientist\Chances\Chance;
use Scientist\Chances\StandardChance;
use Scientist\Matchers\Matcher;
use Scientist\Matchers\StandardMatcher;

/**
 * Class Experiment
 *
 * An experiment allows us to implement our code in a new way without
 * risking the introduction of bugs or regressions.
 *
 * @package Scientist
 */
class Experiment
{
    /**
     * Experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control callback.
     *
     * @var callable
     */
    protected $control;

    /**
     * Context for the control.
     *
     * @var mixed
     */
    protected $controlContext;

    /**
     * Trial callbacks.
     *
     * @var array
     */
    protected $trials = [];

    /**
     * Parameters for our callbacks.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Laboratory instance.
     *
     * @var \Scientist\Laboratory
     */
    protected $laboratory;

    /**
     * Matcher for experiment values.
     *
     * @var \Scientist\Matchers\Matcher
     */
    protected $matcher;

    /**
     * Execution chance.
     *
     * @var \Scientist\Chances\Chance
     */
    protected $chance;

    /**
     * Create a new experiment.
     */
    public function __construct(string $name, Laboratory $laboratory)
    {
        $this->name = $name;
        $this->laboratory = $laboratory;
        $this->matcher = new StandardMatcher;
        $this->chance = new StandardChance;
    }

    /**
     * Fetch the experiment name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieve the laboratory instance.
     */
    public function getLaboratory(): ?Laboratory
    {
        return $this->laboratory;
    }

    /**
     * Register a control callback.
     *
     * @param mixed $context
     */
    public function control(callable $callback, $context = null): self
    {
        $this->control = $callback;
        $this->controlContext = $context;

        return $this;
    }

    /**
     * Fetch the control callback.
     */
    public function getControl(): callable
    {
        return $this->control;
    }

    public function getControlContext()
    {
        return $this->controlContext;
    }

    /**
     * Register a trial callback.
     */
    public function trial(string $name, callable $callback, $context = null): self
    {
        $this->trials[$name] = new Trial($name, $callback, $context);

        return $this;
    }

    /**
     * Fetch a trial callback by name.
     */
    public function getTrial(string $name): callable
    {
        return $this->trials[$name]->getCallback();
    }

    /**
     * Fetch an array of trial callbacks.
     */
    public function getTrials(): array
    {
        return $this->trials;
    }

    /**
     * Set a matcher for this experiment.
     */
    public function matcher(Matcher $matcher): self
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * Get the matcher for this experiment.
     */
    public function getMatcher(): Matcher
    {
        return $this->matcher;
    }

    /**
     * Set the execution chance.
     */
    public function chance(Chance $chance): self
    {
        $this->chance = $chance;

        return $this;
    }

    /**
     * Get the execution chance.
     */
    public function getChance(): Chance
    {
        return $this->chance;
    }

    /**
     * Determine whether an experiment should run based on chance.
     */
    public function shouldRun(): bool
    {
        return $this->chance
            ->shouldRun();
    }

    /**
     * Get the experiment parameters.
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Execute the experiment within the laboratory.
     *
     * @return mixed
     */
    public function run()
    {
        $this->params = func_get_args();

        return $this->laboratory->runExperiment($this);
    }

    /**
     * Execute the experiment and return a report.
     */
    public function report(): Report
    {
        $this->params = func_get_args();

        return $this->laboratory->getReport($this);
    }
}
