<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

use InvalidArgumentException;
use RuntimeException;

/**
 * Class FileNameLock
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30
 */
class FileNameLock implements LockInterface
{
    /** @var string */
    private $name = '';

    /**
     * @param string $resource
     */
    public function __construct($resource = '')
    {
        if (strlen($resource) > 0) {
            $this->setResource($resource);
        }
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

        file_put_contents($this->getResource(), 'process id: ' . getmypid());
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

        unlink($this->getResource());
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return file_exists($this->getResource());
    }

    /**
     * @return mixed|string
     */
    public function getResource()
    {
        if (!$this->isValidName()) {
            return $this->getDefaultName();
        } else {
            return $this->name;
        }
    }

    /**
     * @param mixed|string $resource
     * @throws InvalidArgumentException
     */
    public function setResource($resource)
    {
        if (is_string($resource)) {
            $this->name = (string) ($this->stringEndsWithDotLock($resource)
                ? $resource
                : $resource . '.lock');
        } else {
            throw new InvalidArgumentException(
                'resource must be of type string'
            );
        }
    }

    /**
     * @return bool
     */
    private function stringEndsWithDotLock($string)
    {
        $endsWith           = '.lock';
        $lengthOfEndsWith   = strlen($endsWith);
        $stringEnding       = substr($string, -$lengthOfEndsWith);

        return ($stringEnding == $endsWith);
    }

    /**
     * @return boolean
     */
    private function isValidName()
    {
        return (is_string($this->name) && strlen($this->name) > 0);
    }

    /**
     * @return string
     */
    private function getDefaultName()
    {
        return (string) str_replace('\\', '_', get_class($this)) . '.lock';
    }
}