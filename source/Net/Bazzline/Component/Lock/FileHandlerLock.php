<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-08
 */
namespace Net\Bazzline\Component\Lock;

use InvalidArgumentException;
use RuntimeException;

/**
 * Class FileHandlerLock
 * @package Net\Bazzline\Component\Lock
 */
class FileHandlerLock implements LockInterface
{
    /** @var resource */
    private $fileHandler;

    /** @var bool */
    private $isLocked = false;

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
        if (flock($this->fileHandler, LOCK_EX | LOCK_NB)) {
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
        if (flock($this->fileHandler, LOCK_UN | LOCK_NB)) {
            $this->isLocked = false;
        } else {
            throw new RuntimeException(
                'Can not release lock, no lock exists.'
            );
        }
    }

    /**
     * @return mixed|resource|null
     */
    public function getResource()
    {
        return $this->fileHandler;
    }

    /**
     * @param mixed $resource
     * @throws InvalidArgumentException
     */
    public function setResource($resource)
    {
        if (is_resource($resource)) {
            $this->fileHandler = $resource;
        }
    }
}
