# getTaskCount

Get number of tasks executed

## Description

Returns number of executed stopwatch tasks. One task is next, start-stop, pause-unpause events.

```php
    (int) getTaskCount();
```

## Parameters

No parameters.

## Return values

__int__
: Returns number of tasks stopwatch executed

## Examples

Example #1 One task executed
```php
    $stopwatch = new Stopwatch();
    
    $stopwatch->start();
    $stopwatch->stop();
    
    echo $stopwatch->getTaskCount();
```

Result:
```php
   (int) 1
```

Example #2 Using next method
```php
    $stopwatch = new Stopwatch();
        
    $stopwatch->start('event_1'); # Task 1
    $stopwatch->next('event2'); # Task 2
    $stopwatch->next(); # Task 3
    $stopwatch->next('test'); # Task 4
    $stopwatch->stop();
    
    echo $stopwatch->getTaskCount();
```

Result:
```php
   (int) 4
```

## Notes

_No notes._

## See also

_No documents._
