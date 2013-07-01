# php_component_lock

## General

This component provides the LockInterface as well as an LockAwareInterface. It comes with two implementations of the LockInterface. You can use this interface to lock classes or processes to prevent changes in an object (so you freeze/lock the class for property setting) or lock an existing process (like cronjob) to prevent double execution.

This component was created by splitting up the [PHP_Bazzline_Utility](https://github.com/stevleibelt/PHP_Bazzline_Utility) repository.

## Implementations

Two implementations exists. The FileLock and the RuntimeLock.

### RuntimeLock

The RuntimeLock can be used to lock an instance from modification. If you implement an check in each setter method, you can easily create a instance (by a factory for example) and lock it afterwards to prevent modifications.

### FileLock

The FileLock can be used to lock an class from instantiated multiple times. This is useful if you implement this in cronjobs or business processes that should run alone.

## History

    * v1.0.0
        * Finished LockInterface and LockAwareInterface
        * Added implementation for FileLock and RuntimeLock
        * Covered implementations with unittest