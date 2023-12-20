<?php
declare(strict_types=1);

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
     */
    public function match($control, $trial): bool
    {
        return $control === $trial;
    }
}
