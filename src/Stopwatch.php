<?php

namespace Codervio\Stopwatch;

use Codervio\Stopwatch\StopwatchtypeInterface;
use ReflectionClass;
use ReflectionException;

class Stopwatch implements StopwatchtypeInterface
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

    private function getTimeTypeValue()
    {
        $constants = new ReflectionClass(StopwatchtypeInterface::class);

        $key = array_search($this->getTimeType(), $constants->getConstants());

        return $key;
    }

    public function start($eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'event_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->start($this->getTime(), $eventName);
    }

    public function stop($eventName = null)
    {
        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        //if (!isset($this->time)) {
        //    throw new \LogicException(sprintf('Stopwatch is not started. Use start() function before stop() function.'));
        //}

        return $this->stopwatch->stop($this->getTime(), $eventName);
    }

    public function next($eventName = null)
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

    public function pause($eventName = null)
    {
        if (is_null($eventName)) {
            $this->hashId = $eventName = 'eventpause_' . static::$cnt++;
        } else {
            $this->hashId = $eventName;
        }

        $this->stopwatch->pause($this->getTime(), $eventName);
    }

    public function unpause($eventName = null)
    {
        // add in a total time += current - time from pause

        if (is_null($eventName)) {
            $eventName = $this->hashId;
        }

        //if (!isset($this->time)) {
        //    throw new \LogicException(sprintf('Stopwatch is not started. Use start() function before stop() function.'));
        //}

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
        $prettyData = $this->stopwatch->getRawData();

        $duration = $this->getDuration();

        $top = sprintf("┌%s┐\n", str_repeat('─', 139));


        $mask = "│ %5.5s | %-30.30s | %-30.30s | %-30.30s | %-30.30s │\n";
        //$populateData = printf("┌%s┐\n", str_repeat('─', 139));
        $populateData = $top;

        $populateData .= sprintf($mask, 'Order', 'Consumption time', 'Time', 'Event type', 'Event name');
        $populateData .= sprintf("├%s┤\n", str_repeat('─', 139));

        foreach ($prettyData as $task => $prettyData) {

            foreach ($prettyData as $time => $arr) {

                if ($arr[0][0] === 'end') {
                    $populateData .= sprintf($mask, $task, $arr[0][2]['duration'], $time, $arr[0][0], '... ' . $arr[0][1]);

                } else {
                    $populateData .= sprintf($mask, $task, '', $time, $arr[0][0], '>>> ' . $arr[0][1]);

                }

                $populateData . '┤';


            }

        }

        $spacerterm = '└' . sprintf("%s", str_repeat('─', 139)) . '┘' . PHP_EOL;

        $populateData .= $spacerterm . PHP_EOL;

        return <<<EOF
Stopwatch '$this->stopwatchName': total time ({$this->getTimeTypeValue()}) = $duration, Tasks: {$this->getTaskCount()}
$populateData
EOF;
    }

}
