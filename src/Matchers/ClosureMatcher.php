<?php
declare(strict_types=1);

namespace Scientist\Matchers;

/**
 * Class ClosureMatcher
 *
 * @package \Scientist\Matchers
 */
class ClosureMatcher implements Matcher
{
    /**
     * A closure which attempts to match the results.
     * @var \Closure
     */
    protected $closure;

    /**
     * Create a new matcher instance based on a closure.
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritDoc
     */
    public function match($control, $trial): bool
    {
        return call_user_func($this->closure, $control, $trial);
    }
}
