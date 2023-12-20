<?php
namespace Scientist\Chances;

class StandardChance implements Chance
{
    /**
     * @var int
     */
    private $percentage = 100;

    /**
     * Determine whether or not the experiment should run
     */
    public function shouldRun(): bool
    {
        if ($this->percentage == 0) {
            return false;
        }

        $random = random_int(0, 100);

        return $random <= $this->percentage;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;
        
        return $this;
    }
}
