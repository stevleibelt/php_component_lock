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
 */
class RuntimeLockTest extends PHPUnit_Framework_TestCase
{
    public function testShutdownInterfaceImplemented()
    {
        $className = get_class($this->getNewLock());
        $reflectionObject = new ReflectionClass($className);

        $this->assertTrue($reflectionObject->implementsInterface('\Net\Bazzline\Component\Lock\LockInterface'));
    }

	public function testGetAndSetName()
	{
		$lock = $this->getNewLock(false);
        $name = 'unittest lock name';

		$this->assertTrue((strlen($lock->getResource()) > 0));
		$lock->setResource($name);
		$this->assertEquals($name, $lock->getResource());
	}

	public function testIsLocked_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
	}

	public function testIsLocked_withExistingLock()
	{
		$lock = $this->getNewLock();
        $lock->acquire();

		$this->assertTrue($lock->isLocked());
	}

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
	 */
	public function testLock_withExistingLock()
	{
		$lock = $this->getNewLock();
        $lock->acquire();

		$this->assertTrue($lock->isLocked());
        $lock->acquire();
	}

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
	 */
	public function testUnlock_withNoExistingLock()
	{
		$lock = $this->getNewLock();

        $this->assertFalse($lock->isLocked());
        $lock->release();
	}

    /**
     * @param boolean $setResource
     * @return \Net\Bazzline\Component\Lock\RuntimeLock
     */
    private function getNewLock($setResource = true)
    {
        $lock = new RuntimeLock();
        if ($setResource) {
            $lock->setResource('unittest lock name');
        }

        return $lock;
    }
}