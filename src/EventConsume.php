<?php

namespace Codervio\Stopwatch;

class EventConsume
{
    private $event;

    public function __construct($event) {
        $this->event = $event;
    }

    public function getDuration()
    {
        return $this->event['duration'];
    }

    public function getStart()
    {
        return $this->event['start'];
    }

    public function getStop()
    {
        return $this->event['stop'];
    }

    public function getType()
    {
        return $this->event['type'];
    }

    public function isStopped()
    {
        return (isset($this->event['stop']));
    }
}
