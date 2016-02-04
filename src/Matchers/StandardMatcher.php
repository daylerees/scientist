<?php

namespace Scientist\Matchers;

/**
 * Class StandardMatcher
 *
 * @package \Scientist\Matchers
 */
class StandardMatcher implements Matcher
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
        return $control === $trial;
    }
}
