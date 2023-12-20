<?php
declare(strict_types=1);

namespace Scientist\Chances;

interface Chance
{
    public function shouldRun(): bool;
}
