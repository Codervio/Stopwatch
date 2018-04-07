<?php

namespace Codervio\Stopwatch;

use Codervio\Stopwatch\Exception\EventException;
use Codervio\Stopwatch\StopwatchformatInterface;
use ReflectionClass;
use ReflectionException;
use Codervio\Stopwatch\StopwatchRender;

class Stopwatch implements StopwatchformatInterface
{
    protected static $delta = 19;

    protected static $deltaExp = 9;

    protected $baseDelta = 1;

    protected $stopwatch;

    protected $typeTime;

    private $hashId;

    private $stopwatchName;

    private static $cnt = 1;

    public function __construct($name = '', $typeTime = 1)
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

    public function getEvent($eventName)
    {
        return $this->stopwatch->getEvent($eventName);
    }

    protected function getTimeType()
    {
        return $this->typeTime;
    }

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

    private function getTime()
    {
        if ($this->getTimeType() == 1) {
            return microtime(true);
        }

        if ($this->getTimeType() == 2) {
            return microtime(true) * $this->baseDelta;
        }

        return microtime(true) * $this->baseDelta;
    }

    public function start(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'event_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->start($this->getTime(), $eventName);
    }

    public function stop(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        if (!$this->stopwatch->eventCheck($eventName)) {
            throw new EventException(sprintf("Event '%s' does not started. Add start() event", $eventName));
        }

        return $this->stopwatch->stop($this->getTime(), $eventName);
    }

    public function next(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        $this->stopwatch->stop($this->getTime(), $eventName);

        if (is_null($eventName)) {
            $this->hashId = $eventName = 'event_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->start($this->getTime(), $eventName);
    }

    public function pause(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'eventpause_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->pause($this->getTime(), $eventName);
    }

    public function unpause(?string $eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        if (!$this->stopwatch->eventCheck($eventName)) {
            throw new EventException(sprintf("Event pause '%s' does not started. Add pause() event", $eventName));
        }

        return $this->stopwatch->unpause($this->getTime(), $eventName);
    }

    public function getDuration($eventName = null)
    {
        return $this->stopwatch->getDuration($eventName);
    }

    public function getTimeBorn()
    {
        return $this->stopwatch->getTimeBorn();
    }

    public function getPrettyPrint()
    {
        $render =new StopwatchRender($this->stopwatchName, $this->stopwatch, $this->getTimeType());

        return $render->prettyPrint();
    }
}
