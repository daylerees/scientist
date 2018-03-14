<?php
namespace Scientist\Chances;

class StandardChanceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var StandardChance
     */
    private $chance;

    public function setUp()
    {
        $this->chance = new StandardChance();
    }

    public function test_that_standard_chance_is_an_instance_of_chance()
    {
        $chance = new StandardChance();
        $this->assertInstanceOf('\Scientist\Chances\Chance', $chance);
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
}
