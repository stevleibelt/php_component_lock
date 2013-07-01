<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

/**
 * Class LockInterface
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30
 */
interface LockInterface
{
	/**
     * Validates if lock is acquired
     *
	 * @return boolean
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function isLocked();

	/**
     * Acquires lock
     *
     * @throws \RuntimeException
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function acquire();

	/**
     * Release lock
     *
     * @throws \RuntimeException
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function release();

	/**
     * Returns name or default
     *
     * @return string
     * @return \InvalidArgumentException
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function getName();

	/**
     * Sets name
     *
	 * @param string $name - name of the lock
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function setName($name);
}