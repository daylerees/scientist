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
     * @param mixed $context
     */
    public function __construct(string $name, callable $callback, $context)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->context = $context;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }
}
