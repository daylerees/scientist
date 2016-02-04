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
class Result
{
    /**
     * The experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control execution instance.
     *
     * @var \Scientist\Execution
     */
    protected $control;

    /**
     * The trial execution instances.
     *
     * @var array
     */
    protected $trials = [];

    /**
     * Create a new result instance.
     *
     * @param string               $name
     * @param \Scientist\Execution $control
     * @param array                $trials
     */
    public function __construct($name, Execution $control, array $trials = [])
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
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the control execution instance.
     *
     * @return \Scientist\Execution
     */
    public function control()
    {
        return $this->control;
    }

    /**
     * Get a trial execution instance by name.
     *
     * @param string $name
     *
     * @return \Scientist\Execution
     */
    public function trial($name)
    {
        return $this->trials[$name];
    }

    /**
     * Get the trial execution instances.
     *
     * @return array
     */
    public function trials()
    {
        return $this->trials;
    }
}
