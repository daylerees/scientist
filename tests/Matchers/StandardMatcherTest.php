<?php

use Scientist\Matchers\StandardMatcher;

class StandardMatcherTest extends PHPUnit_Framework_TestCase
{
    public function test_that_standard_matcher_can_be_created()
    {
        $s = new StandardMatcher;
        $this->assertInstanceOf(StandardMatcher::class, $s);
    }

    public function test_that_standard_matcher_can_match_values()
    {
        $s = new StandardMatcher;
        $this->assertTrue($s->match(true, true));
    }

    public function test_that_standard_matcher_can_fail_to_match_values()
    {
        $s = new StandardMatcher;
        $this->assertFalse($s->match(2, 5));
    }

    public function test_that_matcher_is_strict_with_matches()
    {
        $s = new StandardMatcher;
        $this->assertFalse($s->match(false, null));
    }
}
