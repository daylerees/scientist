<?php

namespace Scientist;

/**
 * Class Execution
 *
 * An execution records the state of a callback, including how long it
 * took to execute, and what values were returned.
 *
 * @package \Scientist
 */
class Execution
{
    /**
     * Callback result value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Callback execution time.
     *
     * @var float
     */
    protected $time;

    /**
     * Trial vs control match.
     *
     * @var boolean
     */
    protected $match = false;

    /**
     * Construct a new execution.
     *
     * @param mixed   $value
     * @param float   $time
     * @param boolean $match
     */
    public function __construct($value, $time, $match = false)
    {
        $this->value = $value;
        $this->time  = (float) $time;
        $this->match = (boolean) $match;
    }

    /**
     * Get the callback return value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the callback execution time.
     *
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get the callback to control match status.
     *
     * @return boolean
     */
    public function isMatch()
    {
        return $this->match;
    }

    /**
     * Retrieve the execution in JSON string format.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            'value' => $this->value,
            'time'  => (float) $this->time,
            'match' => (boolean) $this->match
        ]);
    }
}
