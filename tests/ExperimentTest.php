<?php

use Scientist\Experiment;
use Scientist\Laboratory;
use Scientist\Matchers\StandardMatcher;

class ExperimentTest extends PHPUnit_Framework_TestCase
{
    public function test_that_a_new_experiment_can_be_created()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $this->assertInstanceOf(Experiment::class, $e);
    }

    public function test_that_experiment_name_is_set()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $this->assertEquals('test experiment', $e->getName());
    }

    public function test_that_a_control_callback_can_be_defined()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $control = function () {
            return true;
        };
        $e->control($control);
        $this->assertSame($control, $e->getControl());
    }

    public function test_that_a_trial_callback_can_be_defined()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $trial = function () {
            return true;
        };
        $e->trial('trial', $trial);
        $this->assertSame($trial, $e->getTrial('trial'));
    }

    public function test_that_multiple_trial_callbacks_can_be_defined()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $first = function () {
            return 'first';
        };
        $second = function () {
            return 'second';
        };
        $third = function () {
            return 'third';
        };
        $e->trial('first', $first);
        $e->trial('second', $second);
        $e->trial('third', $third);
        $expected = [
            'first'  => $first,
            'second' => $second,
            'third'  => $third
        ];
        $this->assertSame($expected, $e->getTrials());
    }

    public function test_that_a_chance_variable_can_be_set()
    {
        $chance = $this->getMock('\Scientist\Chances\Chance');
        $e = new Experiment('test experiment', new Laboratory);
        $e->chance($chance);
        $this->assertEquals($chance, $e->getChance());
    }

    public function test_that_an_experiment_matcher_can_be_set()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $e->matcher(new StandardMatcher);
        $this->assertInstanceOf(StandardMatcher::class, $e->getMatcher());
    }

    public function test_that_an_experiment_laboratory_can_be_set()
    {
        $l = new Laboratory;
        $e = new Experiment('test experiment', $l);
        $this->assertInstanceOf(Laboratory::class, $e->getLaboratory());
        $this->assertSame($l, $e->getLaboratory());
    }

    public function test_that_running_experiment_with_no_laboratory_executes_control()
    {
        $e = new Experiment('test experiment', new Laboratory);
        $e->control(function () { return 'foo'; });
        $v = $e->run();
        $this->assertEquals('foo', $v);
    }

    public function test_that_running_experiment_with_zero_chance_executes_control()
    {
        $chance = $this->getMockChance();
        $chance->expects($this->once())
            ->method('shouldRun')
            ->willReturn(false);

        $l = new Laboratory;
        $v = $l->experiment('test experiment')
            ->control(function () { return 'foo'; })
            ->chance($chance)
            ->run();

        $this->assertEquals('foo', $v);
    }

    public function getMockChance()
    {
        return $this->getMockBuilder('\Scientist\Chances\Chance')
            ->disableOriginalConstructor()
            ->disableProxyingToOriginalMethods()
            ->getMock();
    }
}
