<?php
declare(strict_types=1);

use Scientist\Matchers\ClosureMatcher;

class ClosureMatcherTest extends \PHPUnit\Framework\TestCase
{
    private function getClosure()
    {
        return function ($control, $trial) {
            return strtoupper($control) == strtoupper($trial);
        };
    }

    public function test_that_closure_matcher_can_be_created()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertInstanceOf(ClosureMatcher::class, $matcher);
    }

    public function test_that_closure_matcher_can_match_values()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertTrue($matcher->match('uppercase', 'UpperCase'));
    }

    public function test_that_closure_matcher_can_fail_to_match_values()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertFalse($matcher->match('uppercase', 'LowerCase'));
    }
}
