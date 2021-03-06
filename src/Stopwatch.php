<?php

namespace Codervio\Stopwatch;

use Codervio\Stopwatch\Drivers\HRTimeDriver;
use Codervio\Stopwatch\Drivers\UnixDriver;
use Codervio\Stopwatch\Exception\EventException;
use Codervio\Stopwatch\StopwatchformatInterface;
use Codervio\Stopwatch\StopwatchRender;

/**
 * Class Stopwatch
 *
 * Stopwatch timer execution component
 *
 * @package Codervio\Stopwatch
 */
class Stopwatch implements StopwatchformatInterface
{
    protected static $delta = 19;

    /**
     * @var int deltaExp
     */
    protected static $deltaExp = 9;

    /**
     * @var int|number baseDelta
     */
    protected $baseDelta = 1;

    /**
     * @var Event stopwatch
     */
    protected $stopwatch;

    /**
     * @var int typeTime
     */
    protected $typeTime;

    /**
     * @var hashId
     */
    private $hashId;

    /**
     * @var string stopwatchName
     */
    private $stopwatchName;

    /**
     * @var int cnt
     */
    private static $cnt = 1;

    /**
     * @var $driver
     */
    private $driver;

    /**
     * @var $driverName
     */
    private $driverName;

    /**
     * Stopwatch constructor.
     *
     * @param null $name Event name, default null is autogenerated event name
     * @param int $typeTime StopwatchformatInterface interface format
     */
    public function __construct($name = null, $typeTime = StopwatchformatInterface::MILLISECONDS)
    {
        $this->typeTime = $typeTime;

        if (!is_null($name)) {
            $this->stopwatchName = (string)$name;
        } else {
            $this->stopwatchName = uniqid();
        }

        $this->baseDelta = $this->retrievePrecision();

        $this->stopwatch = new Event;
    }

    /**
     * Set driver
     *
     * Set UnixDriver or HRTimeDriver driver
     *
     * Default: UnixDriver
     * Uses microtime()
     *
     * @param $driver
     */
    public function setDriver($driver)
    {
        if ($driver instanceof HRTimeDriver) {
            $this->driver = new HRTimeDriver();
            $this->driver->setInitialization($this->getTimeType());
        }

        if ($driver instanceof UnixDriver) {
            $this->driver = new UnixDriver();
            $this->driver->setInitialization($this->getTimeType(), $this->baseDelta);
        }
    }

    /**
     * Get driver instance internally
     *
     * @return mixed
     */
    private function getDriver()
    {
        if (!$this->driver) {
            $this->setDriver(new UnixDriver());
        }

        return $this->driver;
    }

    /**
     * Get driver class name
     *
     * @return string
     */
    public function getDriverName()
    {
        return get_class($this->driver);
    }

    /**
     * Fetch event name
     *
     * @param $eventName Name of event
     * @return EventConsume A class returning of event consumption
     */
    public function getEvent($eventName)
    {
        return $this->stopwatch->getEvent($eventName);
    }

    /**
     * Internally fetch time type
     *
     * @return int
     */
    protected function getTimeType()
    {
        return $this->typeTime;
    }

    /**
     * Fetch name of stopwatch
     *
     * @return string
     */
    public function getId()
    {
        return (string)$this->stopwatchName;
    }

    public function getTaskCount()
    {
        return $this->stopwatch->getTaskCount();
    }

    private function retrievePrecision()
    {
        ini_set('precision', static::$delta);

        if ((int)ini_get('precision') === static::$delta && $this->getTimeType() === 3) {
            return $this->baseDelta = (pow(10, static::$deltaExp));
        }

        return pow(10, 3);
    }

    /**
     * Start a stopwatch timer
     *
     * @param null|string $eventName
     */
    public function start(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'event_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->start($this->getDriver()->start($eventName), $eventName);
    }

    /**
     * Stop a stopwatch timer
     *
     * @param null|string $eventName
     * @return $this
     * @return EventException
     */
    public function stop(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        if ($this->stopwatch->lastEvent()) {
            $event = $this->stopwatch->lastEvent();

            if ($event['type'] == 'start') {
                return $this->stopwatch->stop($this->getDriver()->stop($event['name']), $event['name']);
            }
        }

        if (!$this->stopwatch->eventCheck($eventName)) {
            throw new EventException(sprintf("Event '%s' does not started. Add start() event", $eventName));
        }

        return $this->stopwatch->stop($this->getDriver()->stop($eventName), $eventName);
    }

    /**
     * Automatically start a new timer measurement
     *
     * @param null|string $eventName
     */
    public function next(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'event_' . ++static::$cnt;
        } else {
            $this->hashId = $eventName;
        }

        if ($this->stopwatch->lastEvent()) {
            $event = $this->stopwatch->lastEvent();

            if ($event['type'] == 'start') {
                $this->stopwatch->stop($this->getDriver()->stop($event['name']), $event['name']);
                $this->stopwatch->start($this->getDriver()->start($this->hashId), $this->hashId);
            }
        }
    }

    /**
     * Start freezing timer of stopwatch
     *
     * @param null|string $eventName
     */
    public function pause(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'eventpause_' . ++static::$cnt;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->pause($this->getDriver()->start($eventName), $eventName);
    }

    /**
     * Unfreezing stopwatch timer from pause event
     *
     * @param null|string $eventName
     * @return $this
     */
    public function unpause(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        if (!$this->stopwatch->eventCheck($eventName)) {
            throw new EventException(sprintf("Event pause '%s' does not started. Add pause() event", $eventName));
        }

        return $this->stopwatch->unpause($this->getDriver()->stop($eventName), $eventName);
    }

    /**
     * Measure elapsed stopwatch time
     *
     * @param null $eventName
     * @return string
     */
    public function getDuration($eventName = null)
    {
        $duration = $this->stopwatch->getDuration($eventName);

        return number_format((float)$duration, 2, '.', '');
    }

    /**
     * Get at least first time executed
     *
     * @return mixed
     */
    public function getTimeBorn()
    {
        return $this->stopwatch->getTimeBorn();
    }

    /**
     *
     *
     * @return string
     */
    public function getPrettyPrint()
    {
        $render = new StopwatchRender($this->stopwatchName, $this->stopwatch, $this->getTimeType());

        return $render->prettyPrint();
    }
}
