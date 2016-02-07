<?php


namespace Scientist;

use Scientist\Blind\Preparation;
use Scientist\Matchers\StandardMatcher;

class Study
{
    /**
     * Experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control instance.
     *
     * @var mixed
     */
    protected $control;

    /**
     * Trial instances.
     *
     * @var array
     */
    protected $trials = [];

    /**
     * Laboratory instance.
     *
     * @var \Scientist\Laboratory|null
     */
    protected $laboratory;

    /**
     * Matcher for experiment values.
     *
     * @var \Scientist\Matchers\Matcher
     */
    protected $matcher;

    /**
     * Execution chance.
     *
     * @var integer
     */
    protected $chance = 100;

    /**
     * @var Experiment[]
     */
    protected $experiments = [];

    /**
     * Study constructor.
     * @param string $name
     * @param null|Laboratory $laboratory
     */
    public function __construct($name, $laboratory = null)
    {
        $this->name = $name;
        $this->laboratory = $laboratory;
        $this->matcher = new StandardMatcher;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param mixed $control
     * @return $this
     */
    public function control($control)
    {
        $this->control = $control;
        return $this;
    }

    /**
     * @return array
     */
    public function getTrials()
    {
        return $this->trials;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getTrial($name)
    {
        return $this->trials[$name];
    }

    /**
     * @param string $name
     * @param mixed $trial
     * @return $this
     */
    public function trial($name, $trial)
    {
        $this->trials[$name] = $trial;
        return $this;
    }

    /**
     * @return null|Laboratory
     */
    public function getLaboratory()
    {
        return $this->laboratory;
    }

    /**
     * @param null|Laboratory $laboratory
     */
    public function setLaboratory($laboratory)
    {
        $this->laboratory = $laboratory;
    }

    /**
     * @return Matchers\Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param Matchers\Matcher $matcher
     */
    public function setMatcher($matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * @return int
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * @param int $chance
     */
    public function setChance($chance)
    {
        $this->chance = $chance;
    }

    /**
     * @return Experiment[]
     */
    public function getExperiments()
    {
        return $this->experiments;
    }

    /**
     * @param string $name
     * @return Experiment
     */
    public function getExperiment($name)
    {
        return $this->experiments[$name];
    }

    /**
     * @param Experiment $experiment
     */
    public function addExperiment(Experiment $experiment)
    {
        $this->experiments[$experiment->getName()] = $experiment;
    }

    /**
     * @param string ...$interface blind will implement the interfaces specified
     * @return mixed
     */
    public function blind($interface = null)
    {
        $interfaces = func_get_args();
        if ($interface == null) {
            array_shift($interfaces);
        }

        $preparation = new Preparation();
        return $preparation->prepare($this, $this->getControl(), $this->getTrials(), $interfaces);
    }
}
