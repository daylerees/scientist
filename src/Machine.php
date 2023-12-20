<?php
declare(strict_types=1);

namespace Scientist;

use Throwable;

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
     * @var bool
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
     * @param mixed $context
     */
    public function __construct(callable $callback, array $params = [], bool $muted = false, $context = null)
    {
        $this->callback = $callback;
        $this->params   = $params;
        $this->muted    = $muted;
        $this->result   = new Result($context);
    }

    /**
     * Execute the callback and retrieve a result.
     */
    public function execute(): Result
    {
        $this->setStartValues();
        $this->executeCallback();
        $this->setEndValues();

        return $this->result;
    }

    /**
     * Set values before callback is executed.
     */
    protected function setStartValues(): void
    {
        $this->result->setStartTime(microtime(true));
        $this->result->setStartMemory(memory_get_usage());
    }

    /**
     * Execute the callback with parameters.
     */
    protected function executeCallback(): void
    {
        if ($this->muted) {
            return $this->executeMutedCallback();
        }

        $this->result->setValue(call_user_func_array($this->callback, $this->params));
    }

    /**
     * Execute the callback, but swallow exceptions.
     */
    protected function executeMutedCallback(): void
    {
        try {
            $this->result->setValue(call_user_func_array($this->callback, $this->params));
        } catch (\Throwable $exception) {
            $this->result->setException($exception);
            $this->result->setValue(null);
        }
    }

    /**
     * Set values after the callback has executed.
     */
    protected function setEndValues(): void
    {
        $this->result->setEndTime(microtime(true));
        $this->result->setEndMemory(memory_get_usage());
    }
}
