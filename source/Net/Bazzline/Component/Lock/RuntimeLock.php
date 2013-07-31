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
class RuntimeLock implements LockInterface
{
    /**
     * @var string
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-07-01
     */
    private $name;

    /**
     * @var boolean
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-07-01
     */
    private $isLocked;

	/**
     * @{inheritdoc}
	 */
	public function getName()
	{
        return (is_null($this->name)) ? str_replace('\\', '_', get_class($this)) : $this->name;
	}

	/**
     * @{inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
	}

    /**
     * @{inheritdoc}
     */
    public function isLocked()
    {
        return ((!is_null($this->isLocked)) && ($this->isLocked == true));
    }



    /**
     * @{inheritdoc}
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
     * @{inheritdoc}
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