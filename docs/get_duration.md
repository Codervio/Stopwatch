# getDuration

Fetch duration of execution stopwatch, consumption time

## Description

Measure of execution time in seconds, microseconds or nanoseconds of executed stopwatch timer.

Measurement would not affect on pause/unpause events.

```php
    object(Stopwatch) 
    getDuration($eventName = null)
```

## Parameters

__eventName__
: Name of event
: Default: null
: Empty element will fetch all duration time

## Return values

__EventException__
: Returns exception if event is not started or exists in `start()` method

## Examples

Example #1 Measure consumption time in microseconds (ms) by default
```php
    $stopwatch = new Stopwatch;

    $stopwatch->start();
    
    # sleep 200 ms
    usleep(200000); 
    
    $stopwatch->stop();

    var_dump($stopwatch->getDuration());
```

Result (in ms):
```php
    (int) 200
```

Example #2 Measure consumption time specified by event name
```php
    $stopwatch = new Stopwatch;

    $stopwatch->start('t1');
    usleep(10000); # 10 ms sleep
    $stopwatch->stop('t1');

    $stopwatch->start('t2');
    usleep(20000); # 20 ms sleep
    $stopwatch->stop('t2');

    echo $stopwatch->getDuration('t2');
```

Result:
```php
    (int) 20
```

## Notes

> Duration can be accurately measure elapsed time and can be vary measurements. 

> Pause and unpause function will not include into measurement time.

## See also

_No documents._
