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
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the callback execution start time.
     *
     * @return float
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set the callback execution start time.
     *
     * @param float $startTime
     *
     * @return $this
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get the callback execution end time.
     *
     * @return float
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set the callback execution end time.
     *
     * @param float $endTime
     *
     * @return $this
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get the execution time of the callback.
     *
     * @return float
     */
    public function getTime()
    {
        return $this->endTime - $this->startTime;
    }

    /**
     * Get the callback execution starting memory usage.
     *
     * @return float
     */
    public function getStartMemory()
    {
        return $this->startMemory;
    }

    /**
     * Set the callback execution starting memory usage.
     *
     * @param float $startMemory
     *
     * @return $this
     */
    public function setStartMemory($startMemory)
    {
        $this->startMemory = $startMemory;

        return $this;
    }

    /**
     * Get the callback execution ending memory usage.
     *
     * @return float
     */
    public function getEndMemory()
    {
        return $this->endMemory;
    }

    /**
     * Set the callback execution ending memory usage.
     *
     * @param float $endMemory
     *
     * @return $this
     */
    public function setEndMemory($endMemory)
    {
        $this->endMemory = $endMemory;

        return $this;
    }

    /**
     * Get the memory spike amount of the callback.
     *
     * @return float
     */
    public function getMemory()
    {
        return $this->endMemory - $this->startMemory;
    }

    /**
     * Get the exception thrown by the callback.
     *
     * @return Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set the exception thrown by the callback.
     *
     * @param Exception|null $exception
     *
     * @return $this
     */
    public function setException($exception)
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
     *
     * @return boolean
     */
    public function isMatch()
    {
        return $this->match;
    }

    /**
     * Set whether the callback result matches the control.
     *
     * @param boolean $match
     *
     * @return $this
     */
    public function setMatch($match)
    {
        $this->match = $match;

        return $this;
    }
}
