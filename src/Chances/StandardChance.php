<?php
namespace Scientist\Chances;

class StandardChance implements Chance
{
    private $percentage = 100;

    /**
     * Determine whether or not the experiment should run
     */
    public function shouldRun()
    {
        if ($this->percentage == 0) {
            return false;
        }

        $random = random_int(0, 100);

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
