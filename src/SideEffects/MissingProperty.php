<?php


namespace Scientist\SideEffects;

class MissingProperty extends \RuntimeException
{
    /**
     * MissingProperty constructor.
     * @param string $instance
     * @param string $property
     */
    public function __construct($instance, $property)
    {
        parent::__construct(sprintf(
            "%s does not implement property %s",
            get_class($instance),
            $property
        ));
    }
}
