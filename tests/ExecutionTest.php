<?php

use Scientist\Execution;

class ExecutionTest extends PHPUnit_Framework_TestCase
{
    public function test_that_we_can_create_a_new_execution()
    {
        $e = new Execution('foo', 10.2, true, true);
    }

    public function test_that_we_can_retrieve_a_value_from_an_execution()
    {
        $e = new Execution('foo', 10.0, true, true);
        $this->assertEquals('foo', $e->getValue());
        $e = new Execution('bar', 10.0, true, true);
        $this->assertEquals('bar', $e->getValue());
    }

    public function test_that_we_can_retrieve_an_execution_time_from_an_execution()
    {
        $e = new Execution('foo', 10.2, true, true);
        $this->assertEquals(10.2, $e->getTime());
        $e = new Execution('foo', 5.6, true, true);
        $this->assertEquals(5.6, $e->getTime());
    }

    public function test_that_we_can_retrieve_a_match_status_from_an_execution()
    {
        $e = new Execution('foo', 10.2, true, true);
        $this->assertTrue($e->isMatch());
        $e = new Execution('foo', 10.2, false, true);
        $this->assertFalse($e->isMatch());
    }

    public function test_that_an_execution_can_be_rendered_as_string()
    {
        $e = new Execution('foo', 10.2, true, false);
        $this->assertEquals('{"value":"foo","time":10.2,"match":true}', (string) $e);
    }
}
