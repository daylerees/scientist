<?php

use Scientist\Result;
use Scientist\Machine;

class MachineTest extends \PHPUnit\Framework\TestCase
{
    public function test_that_machine_can_be_created()
    {
        $m = new Machine(function () {});

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function test_that_machine_can_receive_parameters()
    {
        $m = new Machine(function () {}, [1, 2, 3]);

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function test_that_machine_can_receive_mutable_state()
    {
        $m = new Machine(function () {}, [1, 2, 3], true);

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function test_that_machine_can_produce_a_result()
    {
        $m = new Machine(function () {});

        $this->assertInstanceOf(Result::class, $m->execute());
    }

    public function test_that_machine_determines_callback_result_value()
    {
        $m = new Machine(function () { return 'foo'; });

        $this->assertEquals('foo', $m->execute()->getValue());
    }

    public function test_that_machine_sets_context_result()
    {
        $context = ['foo' => 'bar'];

        $m = new Machine(function () { return 'foo'; }, [], true, $context);

        $this->assertSame($context, $m->execute()->getContext());
    }

    public function test_that_machine_executes_callback_with_parameters()
    {
        $m = new Machine(function ($one, $two, $three) {
            return $one + $two + $three;
        }, [1, 2, 3], true);

        $this->assertEquals(6, $m->execute()->getValue());
    }

    public function test_that_exceptions_can_be_thrown_by_machine_callback_execution()
    {
        $m = new Machine(function () { throw new Exception('foo'); });

        $this->expectException(Exception::class);

        $m->execute();
    }

    public static function getErrorData()
    {
        return [
            [new Exception()],
            [new Error()],
        ];
    }

    /**
     * @dataProvider getErrorData
     */
    public function test_that_machine_can_mute_exceptions_from_callback($exception)
    {
        $m = new Machine(function () use ($exception) { throw $exception; }, [], true);

        $this->assertEquals(null, $m->execute()->getValue());
    }

    public function test_that_machine_can_determine_start_and_end_times_for_callbacks()
    {
        $m = new Machine(function () {});

        $s = microtime(true) - 60;
        $r = $m->execute();
        $e = microtime(true) + 60;

        $this->assertIsFloat($r->getStartTime());
        $this->assertIsFloat($r->getEndTime());
        $this->assertGreaterThan($s, $r->getStartTime());
        $this->assertGreaterThan($s, $r->getEndTime());
        $this->assertLessThan($e, $r->getStartTime());
        $this->assertLessThan($e, $r->getEndTime());
    }

    public function test_that_machine_can_determine_memory_usage_changes()
    {
        $m = new Machine(function () {});

        $r = $m->execute();

        $this->assertIsInt($r->getStartMemory());
        $this->assertIsInt($r->getEndMemory());
    }
}
