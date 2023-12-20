<?php
namespace Scientist\Chances;

interface Chance
{
    public function shouldRun(): bool;
}
