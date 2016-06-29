<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24
 */

namespace Net\Bazzline\Component\Lock;

/**
 * Class LockDependentInterface
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24
 */
interface LockDependentInterface
{
    /**
     * Set Lock
     *
     * @param LockInterface $lock
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2014-04-24
     */
    public function setLock(LockInterface $lock);
}
