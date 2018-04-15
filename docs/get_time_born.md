# getTimeBorn

Get at least first time born

## Description

Get at least first time executed in stopwatch instance.

```php
    (string) getTimeBorn();
```

## Parameters

No parameters.

## Return values

__string__
: Returns time in ms, nano or seconds of first time executed.

## Examples

Example #1 Example
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('t1');
    $stopwatch->stop('t1');

    echo $stopwatch->getTimeBorn();
```

Result:
```php
   (float) microseconds time
```

Example #2 Alternative you can fetch via event
```php
    $stopwatch = new Stopwatch;
    
    $stopwatch->start('t1'); # Time born, first time
    $stopwatch->stop('t1');

    $stopwatch->start('t2');
    $stopwatch->stop('t2');

    echo $stopwatch->getEvent('t1')->getStart();
```

Result:
```php
   (string) microseconds time
```

## Notes

_No notes._

## See also

_No documents._
