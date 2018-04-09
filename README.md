# Stopwatch

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codervio/stopwatch.svg?style=flat-square)](https://packagist.org/packages/codervio/stopwatch)
[![Build Status](https://travis-ci.org/Codervio/Stopwatch.svg?branch=master)](https://travis-ci.org/Codervio/Stopwatch)

A `Stopwatch` measures consumption time of executed scripts in micro/nano/mill seconds format. 
It includes `pause` event to freeze consumption time.
A stopwatch time can be named as event stopwatch name.

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
* [`start`] - Start method for stopwatch timer
* [`stop`] - Stop method for stopwatch timer
* [`next`] - Automatically start a new timer measurement
* [`pause`] - Start freezing timer of stopwatch
* [`unpause`] - Stop freezing timer of stopwatch
* [`getDuration`] - Get a duration time consumption