# setDriver

Set Stopwatch driver type.
Not required function.

## Description

```php
setDriver(instance)
```

Instances are located inside `Stopwatch\Drivers` namespace:
- `HRTimeDriver()` - High Resolution Timer [HRTime documentation](http://php.net/manual/en/book.hrtime.php)
- `UnixDriver()` - uses microtime Unix timer

Default:
- `UnixDriver()` - by default it will use microtime()

## Parameters

__instance__
: HRTimeDriver() or UnixDriver()
: Instance inside Drivers directory
: Default: UnixDriver()

## Return values

__void__

No return.

## Examples

Example #1 Set driver
```php
use Codervio\Stopwatch\Stopwatch;

$stopwatch = new Stopwatch();
$stopwatch->setDriver(new HRTimeDriver());
```

## Notes

> By default you are not required to set a driver. It will automatically set to  UnixDriver().

## See also

_No documents._
