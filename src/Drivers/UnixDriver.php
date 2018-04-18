<?php

namespace Codervio\Stopwatch\Drivers;

/**
 * UnixDriver class
 *
 * microtime() native linux timer
 *
 * Class UnixDriver
 * @package Codervio\Stopwatch\Drivers
 */
class UnixDriver
{
    /**
     * @var HRStopWatch $driver
     */
    protected $driver;

    private $baseDelta;

    private $type;

    /**
     * HRTimeDriver constructor.
     */
    public function __construct()
    {

    }

    public function setInitialization($type, $baseDelta)
    {
        $this->type = $type;

        $this->baseDelta = $baseDelta;
    }

    /**
     * Get microtime
     *
     * @return float|int|mixed
     */
    private function getTime()
    {
        if ($this->type == 1) {
            return microtime(true);
        }

        if ($this->type == 2) {
            return microtime(true) * $this->baseDelta;
        }

        return microtime(true) * $this->baseDelta;
    }

    /**
     * Start a timer
     */
    public function start($event): float
    {
        return $this->driver[__FUNCTION__][$event] = $this->getTime();
    }

    /**
     * Stop a timer
     */
    public function stop($event): float
    {
        return $this->driver[__FUNCTION__][$event] = $this->getTime();
    }

    /**
     * Return if stopwatch is running
     *
     * @return bool
     */
    public function isRunning($event): bool
    {
        if (!isset($this->driver['stop'][$event])) {
            return true;
        }

        return false;
    }

    /**
     * 
     */
    public function getLastElapsedTime()
    {
        return;
    }

    /**
     *
     */
    public function getElapsedTime()
    {
        return;
    }
}
