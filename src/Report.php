<?php

namespace Scientist;

/**
 * Class Result
 *
 * Here we have the results of our experiment. My fingers are crossed for
 * you! - Dayle.
 *
 * @package \Scientist
 */
class Report
{
    /**
     * The experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control result.
     *
     * @var \Scientist\Result
     */
    protected $control;

    /**
     * The trial results.
     *
     * @var array
     */
    protected $trials = [];

    /**
     * Create a new result instance.
     *
     * @param string            $name
     * @param \Scientist\Result $control
     * @param array             $trials
     */
    public function __construct($name, Result $control, array $trials = [])
    {
        $this->name    = $name;
        $this->control = $control;
        $this->trials  = $trials;
    }

    /**
     * Get the experiment name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the control result instance.
     *
     * @return \Scientist\Result
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Get a trial result instance by name.
     *
     * @param string $name
     *
     * @return \Scientist\Result
     */
    public function getTrial($name)
    {
        return $this->trials[$name];
    }

    /**
     * Get the trial result instances.
     *
     * @return array
     */
    public function getTrials()
    {
        return $this->trials;
    }
}
