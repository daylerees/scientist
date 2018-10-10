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

    /**
     * @var array
     */
    protected $arguments = [];

    public function __construct($name, callable $callback, $context, array $arguments = [])
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->context = $context;
        $this->arguments = $arguments;
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

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
