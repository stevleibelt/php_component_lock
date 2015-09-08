<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

use InvalidArgumentException;

/**
 * Class LockInterface
 *
 * @package Net\Bazzline\Component\Lock
 */
interface LockInterface
{
	/**
	 * @return boolean
	 */
	public function isLocked();

	/**
     * @throws \RuntimeException
	 */
	public function acquire();

	/**
     * @throws \RuntimeException
	 */
	public function release();

    /**
     * @return mixed
     */
    public function getResource();

    /**
     * @param mixed $resource
     * @throws InvalidArgumentException
     */
    public function setResource($resource);
}