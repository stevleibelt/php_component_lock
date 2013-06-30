<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

/**
 * Class LockAwareInterface
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30
 */
interface LockAwareInterface
{
    /**
     * Set Lock
     *
     * @param LockInterface $lock
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-06-30
     */
    public function setLock(LockInterface $lock);

    /**
     * Get Lock
     *
     * @return LockInterface
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-06-30
     */
    public function getLock();
}