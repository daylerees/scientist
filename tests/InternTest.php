<?php

use Scientist\Intern;
use Scientist\Report;
use Scientist\Experiment;
use Scientist\Laboratory;

class InternTest extends \PHPUnit\Framework\TestCase
{
    public function test_that_intern_can_be_created()
    {
        $i = new Intern;
        $this->assertInstanceOf(Intern::class, $i);
    }

    public function test_that_intern_can_run_an_experiment()
    {
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function () { return 'foo'; });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertEquals('foo', $v->getControl()->getValue());
    }

    public function test_that_intern_can_match_control_and_trial()
    {
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function () { return 'foo'; });
        $e->trial('bar', function () { return 'foo'; });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertTrue($v->getTrial('bar')->isMatch());
    }

    public function test_that_intern_can_mismatch_control_and_trial()
    {
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function () { return 'foo'; });
        $e->trial('bar', function () { return 'bar'; });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertFalse($v->getTrial('bar')->isMatch());
    }

    public function test_that_intern_can_match_and_mismatch_control_and_trial()
    {
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function () { return 'foo'; });
        $e->trial('bar', function () { return 'foo'; });
        $e->trial('baz', function () { return 'baz'; });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertTrue($v->getTrial('bar')->isMatch());
        $this->assertFalse($v->getTrial('baz')->isMatch());
    }

    public function test_that_intern_can_control_and_trial_with_different_arguments()
    {
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function ($input) { return $input; }, null, ['my_var' => 1]);
        $e->trial('bar', function ($input) { return $input*2; }, null, ['my_var' => 2]);
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertFalse($v->getTrial('bar')->isMatch());
        $this->assertEquals(1, $v->getControl()->getValue());
        $this->assertEquals(4, $v->getTrial('bar')->getValue());
    }
}
