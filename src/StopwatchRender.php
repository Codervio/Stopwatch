<?php

namespace Codervio\Stopwatch;

use Codervio\Stopwatch\Exception\EventException;
use Codervio\Stopwatch\StopwatchformatInterface;
use ReflectionClass;
use ReflectionException;

class StopwatchRender implements StopwatchformatInterface
{
    public function __construct($stopwatchName, Event $event, $timeType)
    {
        $this->stopwatchName = $stopwatchName;
        $this->event = $event;
        $this->timeType = $timeType;
    }

    public function prettyPrint() : string
    {
        $prettyData = $this->event->getRawData();

        $duration = $this->event->getDuration();

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
Stopwatch '$this->stopwatchName': total time ({$this->getTimeTypeValue($this->timeType)}) = $duration, Tasks: {$this->event->getTaskCount()}
$populateData
EOF;
    }

    private function getTimeTypeValue($timeType) : string
    {
        $constants = new ReflectionClass(StopwatchformatInterface::class);

        $key = array_search($timeType, $constants->getConstants());

        return $key;
    }
}