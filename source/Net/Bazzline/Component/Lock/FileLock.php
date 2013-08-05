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
class FileLock implements LockInterface
{
	/**
	 * @var string
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	protected $name;

    /**
     * @param string $name
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-08-05
     */
    public function __construct($name = '')
    {
        if (strlen($name) > 0) {
            $this->setName($name);
        }
    }

	/**
     * @{inheritdoc}
	 */
	public function getName()
	{
		if (!$this->isValidName()) {
			return $this->getDefaultName();
		} else {
			return $this->name;
		}
	}

	/**
     * @{inheritdoc}
     * @param string $name - adds a '.lock' if not exists
	 */
	public function setName($name)
	{
		$this->name = (string) ($this->stringEndsWithDotLock($name) ? $name : $name . '.lock');
	}

	/**
	 * @return boolean
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-06-30
	 */
	protected function isValidName()
	{
		return (is_string($this->name) && strlen($this->name) > 0);
	}

	/**
	 * @return string
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-06-30
	 */
	protected function getDefaultName()
	{
		return (string) str_replace('\\', '_', get_class($this)) . '.lock';
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

        touch($this->getName());
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

        unlink($this->getName());
	}

	/**
     * @{inheritdoc}
	 */
	public function isLocked()
	{
		return file_exists($this->getName());
    }



    /**
     * Checks if name ends with lock
     *
     * @param string $string
     * @return bool
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-07-01
     */
    private function stringEndsWithDotLock($string)
    {
        $endsWith = '.lock';
        $lengthOfEndsWith = strlen($endsWith);
        $stringEnding = substr($string, -$lengthOfEndsWith);

        return ($stringEnding == $endsWith);
    }
}