<?php
declare(strict_types=1);

use Scientist\Result;

class ResultTest extends \PHPUnit\Framework\TestCase
{
    public function test_result_can_be_created()
    {
        $r = new Result;

        $this->assertInstanceOf(Result::class, $r);
    }

    public function test_result_can_have_value()
    {
        $r = new Result;
        $r->setValue('foo');
        $this->assertEquals('foo', $r->getValue());
    }

    public function test_result_can_have_start_time()
    {
        $r = new Result;
        $r->setStartTime(123);
        $this->assertEquals(123, $r->getStartTime());
    }

    public function test_result_can_have_end_time()
    {
        $r = new Result;
        $r->setEndTime(123);
        $this->assertEquals(123, $r->getEndTime());
    }

    public function test_result_can_have_start_memory()
    {
        $r = new Result;
        $r->setStartMemory(123);
        $this->assertEquals(123, $r->getStartMemory());
    }

    public function test_result_can_have_end_memory()
    {
        $r = new Result;
        $r->setEndMemory(123);
        $this->assertEquals(123, $r->getEndMemory());
    }

    public function test_result_can_have_exception()
    {
        $r = new Result;
        $r->setException(new Exception);
        $this->assertInstanceOf(Exception::class, $r->getException());
    }

    public function test_result_can_have_match_status()
    {
        $r = new Result;
        $r->setMatch(true);
        $this->assertTrue($r->isMatch());
    }

    public function test_can_have_context()
    {
        $context = ['foo' => 'bar'];

        $r = new Result($context);
        $this->assertSame($context, $r->getContext());
    }

    public function test_result_can_have_total_execution_time()
    {
        $r = new Result;
        $r->setStartTime(2);
        $r->setEndTime(5);
        $this->assertEquals(3, $r->getTime());
    }

    public function test_result_can_have_total_memory_usage()
    {
        $r = new Result;
        $r->setStartMemory(2);
        $r->setEndMemory(5);
        $this->assertEquals(3, $r->getMemory());
    }
}
