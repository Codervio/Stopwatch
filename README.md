# Stopwatch

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codervio/stopwatch.svg?style=flat-square)](https://packagist.org/packages/codervio/stopwatch)
[![Build Status](https://travis-ci.org/Codervio/Stopwatch.svg?branch=master)](https://travis-ci.org/Codervio/Stopwatch)
[![Join the chat at https://gitter.im/Codervio/Stopwatch](https://badges.gitter.im/Codervio/Stopwatch.svg)](https://gitter.im/Codervio/Stopwatch?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

A `Stopwatch` measures consumption time of executed scripts in micro/nano/mill seconds format. 
It includes `pause` event to freeze consumption time.
A stopwatch time can be named as event stopwatch name.
Support drivers using HRTime package or native microtime.

## Donations

Due I am working 100% alone without any helps, organizations and any others team I can be satisfy for receiving any amount of payment to improve, develop and continue building on origin idea of framework.

You can pay any amount to PayPal: https://www.paypal.me/codervio?locale.x=en_US

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

* [`Stopwatch`] - A stopwatch constructor
* [`setDriver`] - Set Stopwatch driver type
* [`getDriverName`] - Get a class name of driver that is using
* [`start`] - Start method for stopwatch timer
* [`stop`] - Stop method for stopwatch timer
* [`next`] - Automatically start a new timer measurement
* [`pause`] - Start freezing timer of stopwatch
* [`unpause`] - Stop freezing timer of stopwatch
* [`getDuration`] - Get a duration time consumption
* [`getEvent`] - Fetch event name
* [`getId`] - Get Id
* [`getTaskCount`] - Get number of tasks executed
* [`getTimeBorn`] - Get at least first time executed
* [`getPrettyPrint`] - Print in a table view rendered stopwatch events

#### GetEvent methods

* [`getDuration`] - Fetch duration of event
* [`getStart`] - Get time of started event
* [`getStop`] - Get time of stop event
* [`getType`] - Get a type of event (run or pause)
* [`isStopped`] - Check is event stopped
* [`isStarted`] - Check is event started
