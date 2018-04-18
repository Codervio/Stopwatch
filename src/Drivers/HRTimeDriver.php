<?php

namespace Codervio\Stopwatch\Drivers;

use HRTime\StopWatch as HRStopWatch;
use HRTime\Unit as Unit;
use Codervio\Stopwatch\Exception\HRTimeExtension;

/**
 * HRTime class
 *
 * High resolution StopWatch timer, best resolution for nanoseconds.
 * Please install PECL extension 'hrtime'
 *
 * Class HRTimeDriver
 * @package Codervio\Stopwatch\Drivers
 */
class HRTimeDriver
{
    /**
     * @var HRStopWatch $driver
     */
    protected $driver;

    protected $type;

    /**
     * HRTimeDriver constructor.
     */
    public function __construct()
    {
        $this->checkExtension();

        $this->driver = new HRStopWatch;
    }

    public function setInitialization($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        if ($this->type == 1) {
            return Unit::SECOND;
        }

        if ($this->type == 2) {
            return Unit::MICROSECOND;
        }

        return Unit::NANOSECOND;
    }

    /**
     * Check hrtime extension
     *
     * @throws \Exception
     */
    private function checkExtension()
    {
        if (!extension_loaded('hrtime')) {
            throw new HRTimeExtension('Extension \'hrtime\' is not loaded. Please install \'hrtime\' extension via PECL package.');
        }
    }

    /**
     * Start a timer
     */
    public function start($eventName)
    {
        $this->driver->start();

        return 0;
    }

    /**
     * Stop a timer
     */
    public function stop($eventName)
    {
        $this->driver->stop();

        return $this->getLastElapsedTime($this->getType());
    }

    /**
     * Return if stopwatch is running
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->driver->isRunning();
    }

    /**
     * Get last task time consumption
     *
     * @return mixed
     */
    public function getLastElapsedTime()
    {
        return $this->driver->getLastElapsedTime($this->getType());
    }

    /**
     * Get total last time consumption
     *
     * @return mixed
     */
    public function getElapsedTime()
    {
        return $this->driver->getElapsedTime($this->getType());
    }
}
