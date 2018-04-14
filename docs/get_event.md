# getEvent

Fetch event name

## Description

Calling event name can fetch EventConsume object for:
 - getting duration
 - time of event started
 - time of event (runned or pause event)
 - type of event (is run or is stop)
 - check if is event stopped (boolean)
 - check if is event started (boolean)

```php
    getEvent($eventName);
    getEvent($eventName)->getDuration();
```

## Functions

```php
    getDuration()
    getStart()
    getStop()
    getType()
    isStopped()
    isStarted()
```

## Parameters

__eventName__
: Name of event
: Required

## Return values

__EventException__
: Returns exception if event is not started or exists in `start()` method

Message:

    There are no %s event or is not started

## Examples

Example #1 Check is event started
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');
    
    $stopwatch->getEvent('event_1')->isStarted();
```

Result (in ms):
```php
    true
```

Example #2 Check is event stopped
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');
    $stopwatch->stop('event_1');

    $stopwatch->getEvent('event_1')->isStopped();
```

Result (in ms):
```php
    true
```

Example #3 Fetch duration of event
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');
    usleep(20000); # Sleep 20ms
    $stopwatch->stop('event_1');

    echo $stopwatch->getEvent('event_1')->getDuration();
```

Result (in ms):
```php
    20
```

Example #4 Get a type of event (run or pause)
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');
    usleep(20000);
    $stopwatch->stop();

    $stopwatch->pause('event_2');
    $stopwatch->unpause();

    echo $stopwatch->getEvent('event_1')->getType();
    echo $stopwatch->getEvent('event_2')->getType();
```

Result (in ms):
```php
    runned # start/stop event_1
    pause # pause/unpause event_2
```

Example #5 Get time of started
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');  # get a time
    usleep(20000);
    $stopwatch->stop();

    echo $stopwatch->getEvent('event_1')->getStart();
```

Result (in ms):
```php
    1523715196.17 ms
```

Example #6 Get time of stop event
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('event_1');
    usleep(20000);
    $stopwatch->stop(); # get a time

    echo $stopwatch->getEvent('event_1')->getStop();
```

Result (in ms):
```php
    1523715197.17 ms
```

## Notes

> getEvent() calls a class EventConsume for retrieving consumption times specified by event.

## See also

_No documents._
