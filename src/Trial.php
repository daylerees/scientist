<?php

namespace Scientist;

class Trial
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var mixed
     */
    protected $context;

    public function __construct($name, callable $callback, $context)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->context = $context;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getContext()
    {
        return $this->context;
    }
}
