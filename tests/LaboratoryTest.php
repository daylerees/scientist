<?php

use Scientist\Report;
use Scientist\Laboratory;

class LaboratoryTest extends PHPUnit_Framework_TestCase
{
    public function test_laboratory_can_be_created()
    {
        $l = new Laboratory;
        $this->assertInstanceOf(Laboratory::class, $l);
    }

    public function test_laboratory_can_run_experiment_with_no_journals()
    {
        $v = (new Laboratory)
            ->experiment('test experiment')
            ->control(function () { return 'foo'; })
            ->trial('trial name', function () { return 'foo'; })
            ->run();

        $this->assertEquals('foo', $v);
    }

    public function test_laboratory_can_fetch_report_for_experiment_with_no_journals()
    {
        $r = (new Laboratory)
            ->experiment('test experiment')
            ->control(function () { return 'foo'; })
            ->trial('trial', function () { return 'bar'; })
            ->report();

        $this->assertInstanceOf(Report::class, $r);
        $this->assertEquals('foo', $r->getControl()->getValue());
        $this->assertEquals('bar', $r->getTrial('trial')->getValue());
        $this->assertInternalType('float', $r->getControl()->getStartTime());
        $this->assertInternalType('float', $r->getControl()->getEndTime());
        $this->assertInternalType('float', $r->getControl()->getTime());
        $this->assertInternalType('float', $r->getTrial('trial')->getStartTime());
        $this->assertInternalType('float', $r->getTrial('trial')->getEndTime());
        $this->assertInternalType('float', $r->getTrial('trial')->getTime());
        $this->assertInternalType('integer', $r->getControl()->getStartMemory());
        $this->assertInternalType('integer', $r->getControl()->getEndMemory());
        $this->assertInternalType('integer', $r->getControl()->getMemory());
        $this->assertInternalType('integer', $r->getTrial('trial')->getStartMemory());
        $this->assertInternalType('integer', $r->getTrial('trial')->getEndMemory());
        $this->assertInternalType('integer', $r->getTrial('trial')->getMemory());
        $this->assertInternalType('null', $r->getControl()->getException());
        $this->assertInternalType('null', $r->getTrial('trial')->getException());
        $this->assertFalse($r->getTrial('trial')->isMatch());
    }

    public function test_that_exceptions_are_thrown_within_control()
    {
        $this->setExpectedException(Exception::class);

        $v = (new Laboratory)
            ->experiment('test experiment')
            ->control(function () { throw new Exception; })
            ->trial('trial', function () { return 'foo'; })
            ->run();
    }

    public function test_that_exceptions_are_swallowed_within_the_trial()
    {
        $r = (new Laboratory)
            ->experiment('test experiment')
            ->control(function () { return 'foo'; })
            ->trial('trial', function () { throw new Exception; })
            ->report();

        $this->assertInstanceOf(Report::class, $r);
        $this->assertInternalType('null', $r->getControl()->getException());
        $this->assertInstanceOf(Exception::class, $r->getTrial('trial')->getException());
    }

    public function test_that_control_and_trials_receive_parameters()
    {
        $r = (new Laboratory)
            ->experiment('test experiment')
            ->control(function ($one, $two) { return $one; })
            ->trial('trial', function ($one, $two) { return $two; })
            ->report('Panda', 'Giraffe');

        $this->assertInstanceOf(Report::class, $r);
        $this->assertEquals('Panda', $r->getControl()->getValue());
        $this->assertEquals('Giraffe', $r->getTrial('trial')->getValue());
    }
}
