<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

/**
 * Class LockAbstract
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30
 */
abstract class LockAbstract implements LockInterface
{
	/**
	 * @author stev leibelt
	 * @var string
	 * @since 2013-01-03
	 */
	protected $name;

	/**
     * {$inheritDoc}
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
     * {$inheritDoc}
	 */
	public function setName($name)
	{
		$this->name = (string) $name . '.lock';
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
}