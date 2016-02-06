<?php


namespace Scientist\SideEffects;


class MissingMethod extends \RuntimeException
{
    /**
     * MissingMethod constructor.
     * @param mixed $instance
     * @param string $method
     */
    public function __construct($instance, $method)
    {
        parent::__construct(sprintf("%s does not implement method %s",
            get_class($instance),
            $method
        ));
    }
}