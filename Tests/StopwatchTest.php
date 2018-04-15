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
        $this->delta = 20;
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

    public function testEventDuration()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->start('event_1');
        usleep(20000);
        $stopwatch->stop();

        $this->assertEquals(20, $stopwatch->getEvent('event_1')->getDuration(), null, 0.5);
    }

    public function testEventGettype()
    {
        $stopwatch = new Stopwatch;
        $stopwatch->start('event_1');
        usleep(20000);
        $stopwatch->stop();

        $stopwatch->pause('event_2');
        $stopwatch->unpause();

        $this->assertEquals('runned', $stopwatch->getEvent('event_1')->getType());
        $this->assertEquals('pause', $stopwatch->getEvent('event_2')->getType());
    }

    public function testEventGetstart()
    {
        $stopwatch = new Stopwatch;

        $started = $stopwatch->start('event_1');
        usleep(20000);
        $stopwatch->stop();

        $start = $stopwatch->getEvent('event_1')->getStart();

        $stopwatch->pause('event_2');
        $stopwatch->unpause();

        $this->assertEquals($start, $stopwatch->getEvent('event_1')->getStart(), null, 100);
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

    public function testStopwatchWithoutNameStopEvent()
    {
        $stopwatch = new Stopwatch();

        $stopwatch->start(__FUNCTION__);
        usleep(100);
        $stopwatch->stop();
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

    public function testNextMethod()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->start('event_1');
        $stopwatch->next('event2');
        $stopwatch->next();
        $stopwatch->next('test');
        $stopwatch->stop();

        $this->assertEquals(4, $stopwatch->getTaskCount());
    }

    public function testTaskCount()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->start('t1');
        $stopwatch->stop('t1');

        $stopwatch->start('t2');
        $stopwatch->stop('t2');

        $stopwatch->start('t3');
        $stopwatch->stop('t3');

        $this->assertEquals(3, $stopwatch->getTaskCount());
    }

    public function testPauseTask()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->start(__FUNCTION__);
        usleep(200000);
        $stopwatch->stop(__FUNCTION__);

        $stopwatch->pause();
        usleep(2000);
        $stopwatch->unpause();

        $this->assertEquals(200, $stopwatch->getDuration(), null, 0.5);
    }

    public function testDurationEvent()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->start('t1');
        usleep(10000);
        $stopwatch->stop('t1');

        $stopwatch->start('t2');
        usleep(20000);
        $stopwatch->stop('t2');

        $stopwatch->start('t3');
        usleep(40000);
        $stopwatch->stop('t3');

        $this->assertEquals(20, $stopwatch->getDuration('t2'), null, 0.5);
    }

    public function testGetId()
    {
        $genid = uniqid();

        $stopwatch = new Stopwatch($genid);

        $id = $stopwatch->getId();

        $this->assertEquals($genid, $id);
    }

    public function testGetTimeBorn()
    {
        $stopwatch = new Stopwatch;

        $stopwatch->start('t1');
        $stopwatch->stop('t1');

        $stopwatch->start('t2');
        $stopwatch->stop('t2');

        $getTime = $stopwatch->getTimeBorn();
        $eventStarted = $stopwatch->getEvent('t1')->getStart();

        $this->assertEquals($eventStarted, $stopwatch->getTimeBorn());
    }

    public function testGetPrettyPrint()
    {
        $stopwatch = new Stopwatch('My stopwatch timer', StopwatchformatInterface::MILLISECONDS);

        $stopwatch->start('t1');
        $stopwatch->stop('t1');

        $stopwatch->start('t2');
        $stopwatch->stop('t2');

        $stopwatch->start('pause 1');
        $stopwatch->stop('pause 1');

        $stopwatch->next();

        $table = $stopwatch->getPrettyPrint();

        $this->assertStringStartsWith('Stopwatch \'My stopwatch timer\': total time (MILLISECONDS) = ', $table);
    }
}
