<?php

use Scientist\Result;
use Scientist\Execution;

class ResultTest extends PHPUnit_Framework_TestCase
{
    public function test_that_result_can_be_created()
    {
        $e = new Execution(true, 10.0, true, true);
        $r = new Result('name', $e, []);
    }

    public function test_that_result_has_experiment_name()
    {
        $e = new Execution(true, 10.0, true, true);
        $r = new Result('name', $e, []);
        $this->assertEquals('name', $r->name());
    }

    public function test_that_result_has_control_execution()
    {
        $e = new Execution(true, 10.0, true, true);
        $r = new Result('name', $e, []);
        $this->assertInstanceOf(Execution::class, $r->control());
        $this->assertEquals(10.0, $r->control()->getTime());
    }

    public function test_that_result_has_trial_executions()
    {
        $control = new Execution(true, 10.0, true, true);
        $trial   = new Execution(true, 82.0, true, true);
        $r = new Result('name', $control, ['bar' => $trial]);
        $this->assertInstanceOf(Execution::class, $r->trial('bar'));
        $this->assertEquals(82.0, $r->trial('bar')->getTime());
    }
}
