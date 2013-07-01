<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-07-01
 */

namespace Net\Bazzline\Component\Lock;

use RuntimeException;

/**
 * Class RuntimeLock
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-07-01
 */
class RuntimeLock extends LockAbstract
{
    /**
     * @var boolean
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-07-01
     */
    private $isLocked;

	/**
     * {$inheritDoc}
	 */
	public function getName()
	{
        return (is_null($this->name)) ? __CLASS__ : $this->name;
	}

	/**
     * {$inheritDoc}
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
	}

    /**
     * {$inheritDoc}
     */
    public function isLocked()
    {
        return ((!is_null($this->isLocked)) && ($this->isLocked == true));
    }



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

        $this->isLocked = true;
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

        $this->isLocked = false;
    }
}