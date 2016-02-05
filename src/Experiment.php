<?php

namespace Scientist;

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
     * @var \Scientist\Laboratory|null
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
     * @var integer
     */
    protected $chance = 100;

    /**
     * Create a new experiment.
     *
     * @param string                     $name
     * @param \Scientist\Laboratory|null $laboratory
     */
    public function __construct($name, $laboratory = null)
    {
        $this->name = $name;
        $this->laboratory = $laboratory;
        $this->matcher = new StandardMatcher;
    }

    /**
     * Fetch the experiment name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the laboratory instance.
     *
     * @param \Scientist\Laboratory $laboratory
     *
     * @return $this
     */
    public function setLaboratory(Laboratory $laboratory)
    {
        $this->laboratory = $laboratory;

        return $this;
    }

    /**
     * Retrieve the laboratory instance.
     *
     * @return \Scientist\Laboratory|null
     */
    public function getLaboratory()
    {
        return $this->laboratory;
    }

    /**
     * Register a control callback.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function control(callable $callback)
    {
        $this->control = $callback;

        return $this;
    }

    /**
     * Fetch the control callback.
     *
     * @return callable
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Register a trial callback.
     *
     * @param string   $name
     * @param callable $callback
     *
     * @return $this
     */
    public function trial($name, callable $callback)
    {
        $this->trials[$name] = $callback;

        return $this;
    }

    /**
     * Fetch a trial callback by name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getTrial($name)
    {
        return $this->trials[$name];
    }

    /**
     * Fetch an array of trial callbacks.
     *
     * @return array
     */
    public function getTrials()
    {
        return $this->trials;
    }

    /**
     * Set a matcher for this experiment.
     *
     * @param \Scientist\Matchers\Matcher $matcher
     *
     * @return $this
     */
    public function matcher(Matcher $matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * Get the matcher for this experiment.
     *
     * @return \Scientist\Matchers\Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Set the execution chance.
     *
     * @param integer $chance
     *
     * @return $this
     */
    public function chance($chance)
    {
        $this->chance = (int) $chance;

        return $this;
    }

    /**
     * Get the execution chance.
     *
     * @return integer
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * Determine whether an experiment should run based on chance.
     *
     * @return boolean
     */
    public function shouldRun()
    {
        return rand(0, 100) <= $this->chance;
    }

    /**
     * Get the experiment parameters.
     *
     * @return array
     */
    public function getParams()
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

        if ($this->laboratory) {
            return $this->laboratory->runExperiment($this);
        }

        return call_user_func($this->control, $this->params);
    }

    /**
     * Execute the experiment and return a result.
     *
     * @return \Scientist\Report
     */
    public function result()
    {
        $this->params = func_get_args();

        return $this->laboratory->getResult($this);
    }
}
