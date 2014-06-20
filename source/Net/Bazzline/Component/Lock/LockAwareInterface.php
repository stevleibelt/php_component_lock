<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30 
 */

namespace Net\Bazzline\Component\Lock;

/**
 * Class LockAwareInterface
 *
 * @package Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30
 */
interface LockAwareInterface extends LockDependentInterface
{
    /**
     * Get Lock
     *
     * @return LockInterface
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-06-30
     */
    public function getLock();
}
