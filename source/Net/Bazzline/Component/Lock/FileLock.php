<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

use RuntimeException;

/**
 * Class FileLock
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30
 */
class FileLock extends LockAbstract
{
	/**
     * {$inheritDoc}
	 */
	public function acquire()
	{
		if ($this->isLocked()) {
			throw new RuntimeException(
                'Can not acquire lock, lock already exists.'
            );
		}

        touch($this->getName());
	}

	/**
     * {$inheritDoc}
	 */
	public function release()
	{
		if (!$this->isLocked()) {
			throw new RuntimeException(
                'Can not release lock, no lock exists.'
            );
		}

        unlink($this->getName());
	}

	/**
     * {$inheritDoc}
	 */
	public function isLocked()
	{
		return file_exists($this->getName());
	}
}