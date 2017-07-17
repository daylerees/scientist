<?php

namespace Scientist;

use Exception;

/**
 * Class Executor
 *
 * @package \Scientist
 */
class Machine
{
    /**
     * The callback to execute.
     *
     * @var callable
     */
    protected $callback;

    /**
     * Parameters to provide to the callback.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Should exceptions be muted.
     *
     * @var boolean
     */
    protected $muted = false;

    /**
     * The result instance.
     *
     * @var \Scientist\Result
     */
    protected $result;

    /**
     * Inject machine dependencies.
     *
     * @param callable $callback
     * @param array    $params
     * @param boolean  $muted
     */
    public function __construct(callable $callback, array $params = [], $muted = false)
    {
        $this->callback = $callback;
        $this->params   = $params;
        $this->muted    = $muted;
        $this->result   = new Result;
    }

    /**
     * Execute the callback and retrieve a result.
     *
     * @return \Scientist\Result
     */
    public function execute()
    {
        $this->setStartValues();
        $this->executeCallback();
        $this->setEndValues();

        return $this->result;
    }

    /**
     * Set values before callback is executed.
     *
     * @return void
     */
    protected function setStartValues()
    {
        $this->result->setStartTime(microtime(true));
        $this->result->setStartMemory(memory_get_usage());
    }

    /**
     * Execute the callback with parameters.
     *
     * @return void
     */
    protected function executeCallback()
    {
        if ($this->muted) {
            return $this->executeMutedCallback();
        }

        $this->result->setValue(call_user_func_array($this->callback, $this->params));
    }

    /**
     * Execute the callback, but swallow exceptions.
     *
     * @return void
     */
    protected function executeMutedCallback()
    {
        try {
            $this->result->setValue(call_user_func_array($this->callback, $this->params));
        } catch (Exception $exception) {
            $this->result->setException($exception);
            $this->result->setValue(null);
        }
    }

    /**
     * Set values after the callback has executed.
     *
     * @return void
     */
    protected function setEndValues()
    {
        $this->result->setEndTime(microtime(true));
        $this->result->setEndMemory(memory_get_usage());
    }
}
