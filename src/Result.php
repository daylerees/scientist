<?php
namespace Scientist;

use Exception;

/**
 * Class Execution
 *
 * An execution records the state of a callback, including how long it
 * took to execute, and what values were returned.
 *
 * @package \Scientist
 */
class Result
{
    /**
     * Callback result value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * The time the callback was executed.
     *
     * @var float
     */
    protected $startTime;

    /**
     * The time the callback finished executing.
     *
     * @var float
     */
    protected $endTime;

    /**
     * The memory usage before the callback is executed.
     *
     * @var float
     */
    protected $startMemory;

    /**
     * The memory usage after the callback is executed.
     *
     * @var float
     */
    protected $endMemory;

    /**
     * Exception thrown by callback.
     *
     * @var \Exception|null
     */
    protected $exception;

    /**
     * Does the callback result value match the control.
     *
     * @var boolean
     */
    protected $match = false;

    /**
     * @var mixed
     */
    protected $context;

    public function __construct($context = null)
    {
        $this->context = $context;
    }

    /**
     * Get the callback result value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the callback result value.
     *
     * @param mixed $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the callback execution start time.
     */
    public function getStartTime(): float
    {
        return $this->startTime;
    }

    /**
     * Set the callback execution start time.
     */
    public function setStartTime(float $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get the callback execution end time.
     */
    public function getEndTime(): float
    {
        return $this->endTime;
    }

    /**
     * Set the callback execution end time.
     */
    public function setEndTime(float $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get the execution time of the callback.
     */
    public function getTime(): float
    {
        return $this->endTime - $this->startTime;
    }

    /**
     * Get the callback execution starting memory usage.
     */
    public function getStartMemory(): float
    {
        return $this->startMemory;
    }

    /**
     * Set the callback execution starting memory usage.
     */
    public function setStartMemory(float $startMemory): self
    {
        $this->startMemory = $startMemory;

        return $this;
    }

    /**
     * Get the callback execution ending memory usage.
     */
    public function getEndMemory(): float
    {
        return $this->endMemory;
    }

    /**
     * Set the callback execution ending memory usage.
     */
    public function setEndMemory(float $endMemory): self
    {
        $this->endMemory = $endMemory;

        return $this;
    }

    /**
     * Get the memory spike amount of the callback.
     */
    public function getMemory(): float
    {
        return $this->endMemory - $this->startMemory;
    }

    /**
     * Get the exception thrown by the callback.
     */
    public function getException(): ?\Throwable
    {
        return $this->exception;
    }

    /**
     * Set the exception thrown by the callback.
     */
    public function setException(?\Throwable $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function getContext()
    {
        return $this->context;
    }

    /**
     * Determine whether the callback result matches the control.
     */
    public function isMatch(): bool
    {
        return $this->match;
    }

    /**
     * Set whether the callback result matches the control.
     */
    public function setMatch(bool $match): self
    {
        $this->match = $match;

        return $this;
    }
}
