# getDriverName

Get a class name of driver that is using

## Description

Returns class name of driver instance.
Location of drivers instance are inside Codervio\Stopwatch\Drivers folder.

```php
    getDriverName();
```

By default it returns UnixDriver driver.

## Parameters

__No parameters.__

## Return values

__string__
: Returns driver name.

Returns:

    Codervio\Stopwatch\Drivers\HRTimeDriver
    Codervio\Stopwatch\Drivers\UnixDriver

## Examples

Example #1 Get a driver name
```php
    $stopwatch = new Stopwatch();
    $stopwatch->getDriverName();
```

Result:
```php
   (string) Codervio\Stopwatch\Drivers\UnixDriver
```

## Notes

_No notes._

## See also

_No documents._
