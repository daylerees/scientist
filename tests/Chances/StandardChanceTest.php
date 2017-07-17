<?php
namespace Scientist\Chances;

use RandomLib\Generator;

class StandardChanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StandardChance
     */
    private $chance;

    /**
     * @var Generator
     */
    private $generator;

    public function setUp()
    {
        $this->generator = $this->getMockGenerator();
        $this->chance = new StandardChance($this->generator);
    }

    public function test_that_standard_chance_is_an_instance_of_chance()
    {
        $chance = new StandardChance();
        $this->assertInstanceOf('\Scientist\Chances\Chance', $chance);
    }

    public function test_that_a_random_number_generator_is_created_upon_instantiation()
    {
        $chance = new StandardChance();
        $reflection = new \ReflectionClass($chance);
        $property = $reflection->getProperty('generator');
        $property->setAccessible(true);

        $this->assertInstanceOf('\RandomLib\Generator', $property->getValue($chance));
    }

    public function test_that_it_takes_a_custom_random_number_generator_in_the_constructor()
    {
        $reflection = new \ReflectionClass($this->chance);
        $property = $reflection->getProperty('generator');
        $property->setAccessible(true);

        $this->assertSame($this->generator, $property->getValue($this->chance));
    }

    /**
     * @dataProvider percentageDataProvider
     */
    public function test_that_should_run_returns_true_when_the_chance_is_100($random)
    {
        $this->generator
            ->expects($this->once())
            ->method('generateInt')
            ->with(0, 100)
            ->willReturn($random);

        $this->assertTrue($this->chance->shouldRun());
    }

    public function test_that_the_default_percentage_is_100()
    {
        $this->assertEquals(100, $this->chance->getPercentage());
    }

    public function test_that_set_percentage_sets_the_percentage()
    {
        $percentage = rand(1, 100);
        $this->chance
            ->setPercentage($percentage);
        $this->assertEquals($percentage, $this->chance->getPercentage());
    }

    public function test_that_set_percentage_returns_the_chance_object_for_chaining()
    {
        $percentage = rand(1, 100);
        $this->assertSame($this->chance, $this->chance->setPercentage($percentage));
    }

    public function test_that_should_run_always_returns_false_when_percentage_is_zero()
    {
        $this->generator
            ->expects($this->never())
            ->method('generateInt');
        $this->chance
            ->setPercentage(0);
        $this->assertFalse($this->chance->shouldRun());
    }

    /**
     * @dataProvider nonZeroPercentageDataProvider
     * @param integer $percentage Percentage of the time to run
     */
    public function test_that_it_returns_true_when_percentage_is_greater_than_the_generated_number($percentage)
    {
        $this->generator
            ->expects($this->once())
            ->method('generateInt')
            ->with(0, 100)
            ->willReturn($percentage - 1);

        $this->chance
            ->setPercentage($percentage);

        $this->assertTrue($this->chance->shouldRun());
    }

    /**
     * @dataProvider nonZeroPercentageDataProvider
     * @param integer $percentage Percentage of the time to run
     */
    public function test_that_it_returns_false_when_percentage_is_less_than_the_generated_number($percentage)
    {
        $this->generator
            ->expects($this->once())
            ->method('generateInt')
            ->with(0, 100)
            ->willReturn($percentage + 1);

        $this->chance
            ->setPercentage($percentage);

        $this->assertFalse($this->chance->shouldRun());
    }

    /**
     * @return array
     */
    public function nonZeroPercentageDataProvider()
    {
        $percentages = $this->percentageDataProvider();
        array_shift($percentages);
        return $percentages;
    }

    /**
     * Data provider to cover all 100 percentage values
     * @return array
     */
    public function percentageDataProvider()
    {
        return array_map(function ($value) {
            return [$value];
        }, range(0, 100));
    }

    public function getMockGenerator()
    {
        return $this->getMockBuilder('\RandomLib\Generator')
            ->disableOriginalConstructor()
            ->disableProxyingToOriginalMethods()
            ->getMock();
    }
}
