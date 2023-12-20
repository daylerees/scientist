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
     * @var Result[]
     */
    protected $trials = [];

    /**
     * Create a new result instance.
     */
    public function __construct(string $name, Result $control, array $trials = [])
    {
        $this->name    = $name;
        $this->control = $control;
        $this->trials  = $trials;
    }

    /**
     * Get the experiment name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the control result instance.
     */
    public function getControl(): Result
    {
        return $this->control;
    }

    /**
     * Get a trial result instance by name.
     */
    public function getTrial(string $name): Result
    {
        return $this->trials[$name];
    }

    /**
     * Get the trial result instances.
     *
     * @return Result[]
     */
    public function getTrials(): array
    {
        return $this->trials;
    }
}
