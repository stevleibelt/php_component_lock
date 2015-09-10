<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-08
 */
namespace Net\Bazzline\Component\Lock;

use InvalidArgumentException;
use RuntimeException;
use SplFileObject;

/**
 * Class FileHandlerLock
 * @package Net\Bazzline\Component\Lock
 */
class FileHandlerLock implements LockInterface
{
    /** @var resource|SplFileObject */
    private $fileHandler;

    /** @var bool */
    private $isLocked = false;

    /** @var bool */
    private $isResource = false;

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->isLocked;
    }

    /**
     * @throws \RuntimeException
     */
    public function acquire()
    {
        if ($this->lockCouldBeAcquired()) {
            $this->isLocked = true;
        } else {
            throw new RuntimeException(
                'Can not acquire lock, lock already exists.'
            );
        }
    }

    /**
     * @throws \RuntimeException
     */
    public function release()
    {
        if ($this->lockCouldBeReleased()) {
            $this->isLocked = false;
        } else {
            throw new RuntimeException(
                'Can not release lock, no lock exists.'
            );
        }
    }

    /**
     * @return mixed|resource|SplFileObject|null
     */
    public function getResource()
    {
        return $this->fileHandler;
    }

    /**
     * @param resource|SplFileObject $resource
     * @throws InvalidArgumentException
     */
    public function setResource($resource)
    {
        if (is_resource($resource)) {
            $this->fileHandler  = $resource;
            $this->isResource   = true;
        } else if ($resource instanceof SplFileObject) {
            $this->fileHandler  = $resource;
            $this->isResource   = false;
        } else {
            throw new InvalidArgumentException(
                'provided resource must be of type "resource" or "SplFileObject"'
            );
        }

    }

    /**
     * @return bool
     */
    private function lockCouldBeAcquired()
    {
        if ($this->isResource) {
            $couldBeAcquired = flock($this->fileHandler, LOCK_EX | LOCK_NB);
        } else {
            $couldBeAcquired = $this->fileHandler->flock(LOCK_EX | LOCK_NB);
        }

        return $couldBeAcquired;
    }

    /**
     * @return bool
     */
    private function lockCouldBeReleased()
    {
        if ($this->isResource) {
            $couldBeAcquired = flock($this->fileHandler, LOCK_UN | LOCK_NB);
        } else {
            $couldBeAcquired = $this->fileHandler->flock(LOCK_UN | LOCK_NB);
        }

        return $couldBeAcquired;
    }
}
