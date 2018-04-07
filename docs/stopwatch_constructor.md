# Stopwatch

An Stopwatch constructor

## Description

```php
Stopwatch($name = null, $typeTime = StopwatchformatInterface::SECONDS)
```

Default:
- `name` - empty name of stopwatch class
- `typeTime` - StopwatchformatInterface format time (s, ms, nanosec)

Stopwatch default initialisation will not starting a time or any measurements.
A name is show using `prettyPrint()` function.

## Parameters

__name__
: A name of stopwatch event
: Default: null

__typeTime__
: A result shown in type of time formats using StopwatchformatInterface
: Using StopwatchformatInterface::MICROSECONDS
: Default: `1`, microseconds

Type times:

- SECONDS
- MILLISECONDS
- NANOSECONDS

## Return values

No returns.

## Examples

Example #1 Instantiate and example of time
```php
use Codervio\Stopwatch\Stopwatch;

$stopwatch = new Stopwatch('My stopwatch', Stopwatch::SECONDS);
$stopwatch->start();
sleep(1);
$stopwatch->stop();

echo $stopwatch->getDuration();
```

```php
1.00
```

By default it is microseconds:
```php
use Codervio\Stopwatch\Stopwatch;

$stopwatch = new Stopwatch('My stopwatch');
$stopwatch->start();
sleep(1);
$stopwatch->stop();

echo $stopwatch->getDuration();
```

```php
1000
```

## Notes

> By default event name is internally created.
 A sample event is `event_1` and increasing for new events name.

## See also

_No documents._
