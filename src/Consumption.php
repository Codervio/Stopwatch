<?php

namespace Codervio\Stopwatch;

class Consumption
{
    private $start;
    private $end;

    public function __construct($end, $start) {
        $this->end = $end;
        $this->start = $start;
    }

    public function getConsumptionTime()
    {
        return (float)$this->end - (float)$this->start;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getStop()
    {
        return $this->end;
    }
}
