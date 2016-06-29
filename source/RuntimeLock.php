<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-07-01
 */

namespace Net\Bazzline\Component\Lock;

use InvalidArgumentException;
use RuntimeException;

/**
 * Class RuntimeLock
 *
 * @package Net\Bazzline\Component\Lock
 */
class RuntimeLock implements LockInterface
{
    /** @var string */
    private $name;

    /** @var boolean */
    private $isLocked;

    /**
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct($name = '')
    {
        if (strlen($name) > 0) {
            $this->setResource($name);
        }
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return ((!is_null($this->isLocked)) && ($this->isLocked == true));
    }



    /**
     * @throws \RuntimeException
     */
    public function acquire()
    {
        if ($this->isLocked()) {
            throw new RuntimeException(
                'Can not acquire lock, lock already exists.'
            );
        }

        $this->isLocked = true;
    }



    /**
     * @throws \RuntimeException
     */
    public function release()
    {
        if (!$this->isLocked()) {
            throw new RuntimeException(
                'Can not release lock, no lock exists.'
            );
        }

        $this->isLocked = false;
    }

    /**
     * @return mixed|string
     */
    public function getResource()
    {
        return (is_null($this->name)) ? str_replace('\\', '_', get_class($this)) : $this->name;
    }

    /**
     * @param mixed|string $resource
     * @throws InvalidArgumentException
     */
    public function setResource($resource)
    {
        $this->name = (string) $resource;
    }
}