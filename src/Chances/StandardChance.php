<?php
namespace Scientist\Chances;

use RandomLib\Factory;
use RandomLib\Generator;

class StandardChance implements Chance
{
    private $generator;

    private $percentage = 100;

    /**
     * StandardChance constructor.
     * @param Generator|null $generator
     */
    public function __construct(Generator $generator = null)
    {
        if ($generator === null) {
            $factory = new Factory;
            $generator = $factory->getLowStrengthGenerator();
        }
        $this->generator = $generator;
    }

    /**
     * Determine whether or not the experiment should run
     */
    public function shouldRun()
    {
        if ($this->percentage == 0) {
            return false;
        }

        $random = $this->generator
            ->generateInt(0, 100);
        return $random <= $this->percentage;
    }

    /**
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param int $percentage
     * @return $this
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }
}
