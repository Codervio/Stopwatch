# Stopwatch

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codervio/stopwatch.svg?style=flat-square)](https://packagist.org/packages/codervio/stopwatch)
[![Build Status](https://travis-ci.org/Codervio/Stopwatch.svg?branch=master)](https://travis-ci.org/Codervio/Stopwatch)
[![Join the chat at https://gitter.im/Codervio/Stopwatch](https://badges.gitter.im/Codervio/Stopwatch.svg)](https://gitter.im/Codervio/Stopwatch?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

A `Stopwatch` measures consumption time of executed scripts in micro/nano/mill seconds format. 
It includes `pause` event to freeze consumption time.
A stopwatch time can be named as event stopwatch name.
Support drivers using HRTime package or native microtime.

## Installation

1. Installation via [Composer](http://www.composer.org) on [Packagist](https://packagist.org/packages/codervio/stopwatch)
2. Installation using [Git](http://www.github.com) GIT clone component

## Changelog

Status of core:

| Version       | State                |
| ------------- |:-------------------- |
| `1.0`         | Release version      |

PHP version above `7.1`.
Quality assurance: Unit tests provided

#### References

* [`Stopwatch`](stopwatch_constructor.md) - A stopwatch constructor
* [`setDriver`](set_driver.md) - Set Stopwatch driver type
* [`getDriverName`](get_driver_name.md) - Get a class name of driver that is using
* [`start`](start.md) - Start method for stopwatch timer
* [`stop`](stop.md) - Stop method for stopwatch timer
* [`next`](next.md) - Automatically start a new timer measurement
* [`pause`](pause.md) - Start freezing timer of stopwatch
* [`unpause`](unpause.md) - Stop freezing timer of stopwatch
* [`getDuration`](get_duration.md) - Get a duration time consumption
* [`getEvent`](get_event.md) - Fetch event name
* [`getId`](get_id.md) - Get Id
* [`getTaskCount`](get_task_count.md) - Get number of tasks executed
* [`getTimeBorn`](get_time_born.md) - Get at least first time executed
* [`getPrettyPrint`](get_pretty_print.md) - Print in a table view rendered stopwatch events

#### GetEvent methods

* [`getDuration`](get_event.md) - Fetch duration of event
* [`getStart`](get_event.md) - Get time of started event
* [`getStop`](get_event.md) - Get time of stop event
* [`getType`](get_event.md) - Get a type of event (run or pause)
* [`isStopped`](get_event.md) - Check is event stopped
* [`isStarted`](get_event.md) - Check is event started
