<?php

namespace Codervio\Stopwatch\Tests;

use Codervio\Stopwatch\Stopwatch;
use Codervio\Stopwatch\StopwatchformatInterface;
use PHPUnit\Framework\TestCase;

/**
 * Stopwatch unit test
 *
 */
class StopwatchTest extends TestCase
{
    public $instance;

    private $delta;

    protected function setUp()
    {
        $this->delta = 19;
    }

    public function testStartEvent()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->start('event_1');

        $this->assertFalse($stopwatch->getEvent('event_1')->isStopped());
    }

    public function testStopEvent()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->start('event_1');
        $stopwatch->stop();

        $this->assertTrue($stopwatch->getEvent('event_1')->isStopped());
    }

    /**
     * @expectedException Codervio\Stopwatch\Exception\EventException
     */
    public function testIsStopException()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->stop();
    }

    /**
     * @expectedException Codervio\Stopwatch\Exception\EventException
     */
    public function testIsNotStarted()
    {
        $stopwatch = new Stopwatch;

        $this->assertFalse($stopwatch->getEvent('event_1')->isStarted());
    }

    public function testIsStarted()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->start('event_1');

        $this->assertTrue($stopwatch->getEvent('event_1')->isStarted());
    }

    /**
     * @expectedException Codervio\Stopwatch\Exception\EventException
     */
    public function testUnknownEvent()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->getEvent('unknown');
    }

    public function testStopwatchMicroseconds()
    {
        $stopwatch = new Stopwatch();

        $stopwatch->start(__FUNCTION__);
        usleep(10000);
        $stopwatch->stop(__FUNCTION__);

        $this->assertEquals(0.01, $stopwatch->getDuration(), null, $this->delta);
    }

    public function testStopwatchMills()
    {
        $stopwatch = new Stopwatch(__FUNCTION__, StopwatchformatInterface::MILLISECONDS);

        $stopwatch->start(__FUNCTION__);
        usleep(10000);
        $stopwatch->stop(__FUNCTION__);

        $this->assertEquals(0.01, $stopwatch->getDuration(), null, $this->delta);
    }

    public function testStopwatchSeconds()
    {
        $stopwatch = new Stopwatch(__FUNCTION__, StopwatchformatInterface::SECONDS);

        $stopwatch->start(__FUNCTION__);
        usleep(20000);
        $stopwatch->stop(__FUNCTION__);

        $this->assertEquals(0.02, $stopwatch->getDuration(), null, $this->delta);
    }

    public function testStopwatchNanoseconds()
    {
        $stopwatch = new Stopwatch(__FUNCTION__, StopwatchformatInterface::NANOSECONDS);

        $stopwatch->start(__FUNCTION__);
        usleep(30000);
        $stopwatch->stop(__FUNCTION__);

        $this->assertEquals(30163200, $stopwatch->getDuration(), null, (pow(10, $this->delta)));
    }
}
