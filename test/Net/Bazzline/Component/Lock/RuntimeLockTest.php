<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30 
 */

namespace Test\Net\Bazzline\Component\Lock;

use Net\Bazzline\Component\Lock\RuntimeLock;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use ReflectionClass;

/**
 * Class FileLockTest
 *
 * @package Test\Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-07-01
 */
class RuntimeLockTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
     */
    public function testShutdownInterfaceImplemented()
    {
        $className = get_class($this->getNewLock());
        $reflectionObject = new ReflectionClass($className);

        $this->assertTrue($reflectionObject->implementsInterface('\Net\Bazzline\Component\Lock\LockInterface'));
    }

	/**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testGetAndSetName()
	{
		$lock = $this->getNewLock(false);
        $name = 'unittest lock name';

		$this->assertTrue((strlen($lock->getName()) > 0));
		$lock->setName($name);
		$this->assertEquals($name, $lock->getName());
	}

	/**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testIsLocked_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testIsLocked_withExistingLock()
	{
		$lock = $this->getNewLock();
        $lock->acquire();

		$this->assertTrue($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testLock_withNoExistingLock()
	{
		$lock = $this->getNewLock();

        $this->assertFalse($lock->isLocked());
        $lock->acquire();
        $this->assertTrue($lock->isLocked());
	}

	/**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Can not acquire lock, lock already exists.
     *
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testLock_withExistingLock()
	{
		$lock = $this->getNewLock();
        $lock->acquire();

		$this->assertTrue($lock->isLocked());
        //should throw exception
        $lock->acquire();
	}

	/**
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testUnlock_withExistingLock()
	{
		$lock = $this->getNewLock();
        $lock->acquire();

        $this->assertTrue($lock->isLocked());
        $lock->release();
		$this->assertFalse($lock->isLocked());
	}

	/**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Can not release lock, no lock exists.
     *
     * @author stev leibelt <artodeto@bazzline.net>
     * @since 2013-07-01
	 */
	public function testUnlock_withNoExistingLock()
	{
		$lock = $this->getNewLock();

        $this->assertFalse($lock->isLocked());
        $lock->release();
	}

    /**
     * @param boolean $setName
     * @return \Net\Bazzline\Component\Lock\RuntimeLock
     * @author stev leibelt
     * @since 2013-07-01
     */
    private function getNewLock($setName = true)
    {
        $lock = new RuntimeLock();
        if ($setName) {
            $lock->setName('unittest lock name');
        }

        return $lock;
    }
}