<?php

namespace Scientist\Matchers;

/**
 * Interface Matcher
 *
 * Matchers allow you to alter the success criteria of an experiment.
 *
 * @package Scientist\Matchers
 */
interface Matcher
{
    /**
     * Determine whether two values match.
     *
     * @param mixed $control
     * @param mixed $trial
     *
     * @return boolean
     */
    public function match($control, $trial);
}
