<?php

use Scientist\Intern;
use Scientist\Report;
use Scientist\Experiment;
use Scientist\Laboratory;

class InternTest extends PHPUnit_Framework_TestCase
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

    public function test_that_intern_can_mismatch_multiple_params()
    {
        $sum_closure = function ($a, $b) { return $a + $b; };
        $wrong_sum_closure = function ($a, $b) { return $a * $b; };
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control($sum_closure);
        $e->trial('sum', $wrong_sum_closure);
        $e->report([[2, 2], [2, 3]]);
        $v = $i->run($e);
        $this->assertTrue(is_array($v));
        $this->assertTrue($v[0]->getTrial('sum')[0]->isMatch());
        $this->assertFalse($v[0]->getTrial('sum')[1]->isMatch());
    }

    public function test_that_intern_can_match_multiple_params()
    {
        $sum_closure = function ($a, $b) { return $a + $b; };
        $inverse_sum_closure = function ($a, $b) { return $b + $a; };
        $i = new Intern;
        $e = new Experiment('test experiment', new Laboratory);
        $e->control($sum_closure);
        $e->trial('sum', $inverse_sum_closure);
        $e->report([[2, 2], [2, 3]]);
        $v = $i->run($e);
        $this->assertTrue(is_array($v));
        $this->assertTrue($v[0]->getTrial('sum')[0]->isMatch());
        $this->assertTrue($v[0]->getTrial('sum')[1]->isMatch());
    }
}
