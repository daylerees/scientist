<?php


use Blind\BlindAsset;
use Scientist\Experiment;
use Scientist\Study;

class BlindTest extends PHPUnit_Framework_TestCase
{
    public function test_that_blind_maps_public_method_calls_to_experiment()
    {
        $experimentMock = $this->getMockBuilder(Experiment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $experimentMock->expects($this->any())
            ->method('getName')
            ->willReturn('test::method');
        $experimentMock->expects($this->once())
            ->method('run')
            ->with('foo')
            ->willReturn('bar');

        $blind = new BlindAsset(new Study('test'), [$experimentMock]);
        $this->assertEquals('bar', $blind->method('foo'));
    }

    public function test_that_blind_maps_public_attribute_access_to_experiment()
    {
        $experimentMock = $this->getMockBuilder(Experiment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $experimentMock->expects($this->any())
            ->method('getName')
            ->willReturn('test::$attribute');
        $experimentMock->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive(['attribute'], ['attribute', 'baz'])
            ->willReturnOnConsecutiveCalls('bar', 'baz');

        $blind = new BlindAsset(new Study('test'), [$experimentMock]);
        $this->assertEquals('bar', $blind->attribute);
        $this->assertEquals('baz', $blind->attribute = 'baz');
    }

    public function test_that_blind_maps_isset_to_attribute_experiment()
    {
        $experimentMock = $this->getMockBuilder(Experiment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $experimentMock->expects($this->any())
            ->method('getName')
            ->willReturn('test::$attribute');
        $experimentMock->expects($this->exactly(2))
            ->method('run')
            ->with('attribute')
            ->willReturnOnConsecutiveCalls(null, 'fiz');

        $blind = new BlindAsset(new Study('test'), [$experimentMock]);
        $this->assertFalse(isset($blind->attribute));
        $this->assertTrue(isset($blind->attribute));
    }

    public function test_that_blind_maps_unset_to_attribute_experiment()
    {
        $experimentMock = $this->getMockBuilder(Experiment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $experimentMock->expects($this->any())
            ->method('getName')
            ->willReturn('test::$attribute');
        $experimentMock->expects($this->once())
            ->method('run')
            ->with('attribute', null);

        $blind = new BlindAsset(new Study('test'), [$experimentMock]);
        unset($blind->attribute);
    }
}
