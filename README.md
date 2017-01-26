# Process Lock Component

The build status of the current master branch is tracked by Travis CI: 
[![Build Status](https://travis-ci.org/stevleibelt/php_component_lock.png?branch=master)](http://travis-ci.org/stevleibelt/php_component_lock)

[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/component_lock.svg)](https://packagist.org/packages/net_bazzline/component_lock)

The scrutinizer status is:
[![code quality](https://scrutinizer-ci.com/g/stevleibelt/php_component_lock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stevleibelt/php_component_lock/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/5773c8a599ed290049b8b9da/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5773c8a599ed290049b8b9da)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_lock).

# General

This component provides the *LockInterface* as well as an *LockAwareInterface*. It comes with two implementations of the LockInterface.

You can use this interface to lock classes or processes to prevent changes in an object (so you freeze/lock the class for property setting) or lock an existing process (like a cronjob) to prevent double execution.

This component was created by splitting up the [PHP_Bazzline_Utility](https://github.com/stevleibelt/archive/tree/master/php/bazzlineUtility) repository.

# Implementations

Two implementations exists. The *FileNameLock* and the *RuntimeLock*.

## RuntimeLock

The RuntimeLock can be used to lock an instance from modification. If you implement an check in each setter method, you can easily create a instance (by a factory for example) and lock it afterwards to prevent modifications.

## FileNameLock

The FileNameLock can be used to lock an class from instantiated multiple times. This is useful if you implement this in cronjobs or business processes that should run alone.

## FileHandlerLock

The FileHandlerLock can be used to lock file with php`s [flock](https://secure.php.net/manual/en/function.flock.php) functionality.

# Future Improvements

* implement "wait" like implemented [here](https://github.com/thecodingmachine/utils.common.lock/blob/master/src/LockInterface.php).
* take a look to the [semaphore](https://github.com/zerkalica/Semaphore) project to see if thing can be merged
* take a look if all projects can work together
* take a look to [havvg/lock](https://github.com/havvg/Lock)

# History

* upcomming
    * @todo
* [2.3.0](https://github.com/stevleibelt/php_component_lock/tree/2.3.0) - released 2017-01-26
    * updated minimum requirements to php 5.6
* [2.2.1](https://github.com/stevleibelt/php_component_lock/tree/2.2.1) - released 2016-06-29
    * added integrationtest for php 7.0
    * added links to:
        * latest stable build
        * scrutinizer code quality
        * versioneye dependency status
    * migrated to psr-4 autoloading
    * removed integrationtest for php 5.3.3
* [2.2.0](https://github.com/stevleibelt/php_component_lock/tree/2.2.0) - released 2016-06-28
    * added phpunit 5.4 as dependency (if php version is fitting)
    * added process id into the lock file as requested as [feature](https://github.com/stevleibelt/php_component_lock/issues/1)
    * updated dependencies
* [2.1.0](https://github.com/stevleibelt/php_component_lock/tree/2.1.0) - released 2015-09-10
    * implemented support for *SplFileObject* in *FileHandlerLock*
* [2.0.1](https://github.com/stevleibelt/php_component_lock/tree/2.0.1) - released 2015-09-09
    * stabalized dependencies
* [2.0.0](https://github.com/stevleibelt/php_component_lock/tree/2.0.0) - released 2015-09-08
    * added *FileHandlerLock*
    * renamed *FileLock* to *FileNameLock*
    * renamed "getName" to "getResource" and "setName" to "setResource" in "LockInterface"
* [1.0.3](https://github.com/stevleibelt/php_component_lock/tree/1.0.3)
    * added LockDependentInterface 
* [1.0.2](https://github.com/stevleibelt/php_component_lock/tree/1.0.2)
    * added constructor with optional parameter $name for *FileNameLock* and *RuntimeLock*
* [1.0.1](https://github.com/stevleibelt/php_component_lock/tree/1.0.1)
    * switched to LGPLv3
* [1.0.0](https://github.com/stevleibelt/php_component_lock/tree/v1.0.0)
    * added implementation for *FileLock* and *RuntimeLock*
    * covered implementations with unittest
    * finished *LockInterface* and *LockAwareInterface*

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it. [Donate something](https://gratipay.com/~stevleibelt) if you love it :-].
