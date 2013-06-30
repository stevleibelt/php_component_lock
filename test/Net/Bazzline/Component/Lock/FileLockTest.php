<?php
/**
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30 
 */

namespace Test\Net\Bazzline\Component\Lock;

use Net\Bazzline\Component\Lock\FileLock;
use PHPUnit_Framework_TestCase;
use \RuntimeException;
use ReflectionClass;

/**
 * Class FileLockTest
 *
 * @package Test\Net\Bazzline\Component\Lock
 * @author stev leibelt <artodeto@arcor.de>
 * @since 2013-06-30
 */
class FileLockTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	private $lockFilePath;

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	protected function setUp()
	{
		$this->lockFilePath = '/tmp/' . str_replace('\\', '_', get_class($this));
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	protected function tearDown()
	{
		$this->releaseLock();
	}

    /**
     * @author stev leibelt <artodeto@arcor.de>
     * @since 2013-01-29
     */
    public function testShutdownInterfaceImplemented()
    {
        $className = get_class($this->getNewLock());
        $reflectionObject = new ReflectionClass($className);

        $this->assertTrue($reflectionObject->implementsInterface('\Net\Bazzline\Component\Lock\LockInterface'));
    }

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testGetAndSetName()
	{
		$lock = $this->getNewLock(false);

		$this->assertTrue((strlen($lock->getName()) > 0));
		$lock->setName($this->lockFilePath);
		$this->assertEquals($this->lockFilePath . '.lock', $lock->getName());
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testIsLocked_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testIsLocked_withExistingLock()
	{
		$this->acquireLock();
		$lock = $this->getNewLock();

		$this->assertTrue($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testLock_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		try {
			$this->assertFalse($lock->isLocked());
			$lock->acquire();
		} catch (\RuntimeException $exception) {
			$this->fail('no exception expected.' . PHP_EOL . $exception->getMessage());
		}
		$this->assertTrue($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testLock_withExistingLock()
	{
		$this->acquireLock();
		$lock = $this->getNewLock();

		$this->assertTrue($lock->isLocked());
		try {
			$lock->acquire();
		} catch (\RuntimeException $exception) {
			$this->assertTrue($lock->isLocked());
			$this->assertEquals('Can not acquire lock, lock already exists.', $exception->getMessage());

			return 0;
		}
		$this->fail('Exception expected.');
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testUnlock_withExistingLock()
	{
		$this->acquireLock();
		$lock = $this->getNewLock();

		try {
			$this->assertTrue($lock->isLocked());
			$lock->release();
		} catch (\RuntimeException $exception) {
			$this->fail('no exception expected.' . PHP_EOL . $exception->getMessage());
		}
		$this->assertFalse($lock->isLocked());
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	public function testUnlock_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		try {
			$this->assertFalse($lock->isLocked());
			$lock->release();
		} catch (\RuntimeException $exception) {
			$this->assertEquals('Can not release lock, no lock exists.', $exception->getMessage());
			$this->assertFalse($lock->isLocked());

			return 0;
		}
		$this->fail('Exception expected.');
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	private function acquireLock()
	{
		touch ($this->lockFilePath . '.lock');
	}

	/**
     * @author stev leibelt <artodeto@arcor.de>
	 * @since 2013-01-03
	 */
	private function releaseLock()
	{
		$lockFileName = $this->lockFilePath . '.lock';

		if (file_exists($lockFileName)) {
			unlink ($lockFileName);
		}
	}

    /**
     * @param boolean $setName
     * @return \Net\Bazzline\Component\Lock\FileLock
     * @author stev leibelt
     * @since 2013-01-03
     */
    private function getNewLock($setName = true)
    {
        $lock = new FileLock();
        if ($setName) {
            $lock->setName($this->lockFilePath);
        }

        return $lock;
    }
}