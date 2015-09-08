<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-08
 */
namespace Test\Net\Bazzline\Component\Lock;

use Net\Bazzline\Component\Lock\FileHandlerLock;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use RuntimeException;

class FileHandlerLockTest extends PHPUnit_Framework_TestCase
{
	/** @var string */
	private $filePath;

    /** @var resource */
    private $fileHandler;

    /** @var resource */
    private $internalFileHandler;


	protected function setUp()
	{
        //@todo use vfsStream
		$this->filePath             = '/tmp/' . str_replace('\\', '_', get_class($this));

        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }

        $this->fileHandler          = fopen($this->filePath, 'r+');
        $this->internalFileHandler  = fopen($this->filePath, 'r+');
	}

	protected function tearDown()
	{
		$this->releaseLock();
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
	}

    public function testShutdownInterfaceImplemented()
    {
        $className  = get_class($this->getNewLock());
        $reflection = new ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface('\Net\Bazzline\Component\Lock\LockInterface'));
    }

	public function testIsLocked_withNoExistingLock()
	{
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
	}

	public function testIsLocked_withExistingLock()
	{
		$this->acquireLock();
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
	}

	public function testAcquireLockWithNoExistingLock()
	{
		$lock = $this->getNewLock();

        $this->assertFalse($lock->isLocked());
        $lock->acquire();
		$this->assertTrue($lock->isLocked());
	}

    /**
     * @expectedException RuntimeException
     */
	public function testAquireLockWithExistingLock()
	{
		$this->acquireLock();
		$lock = $this->getNewLock();

		$this->assertFalse($lock->isLocked());
        $lock->acquire();
	}

	private function acquireLock()
	{
        if (!flock($this->internalFileHandler, LOCK_EX | LOCK_NB)) {
            throw new RuntimeException(
                'could not acquire lock'
            );
        }
	}

	private function releaseLock()
	{
        if (!flock($this->internalFileHandler, LOCK_UN)) {
            throw new RuntimeException(
                'could not release lock'
            );
        }
	}

    /**
     * @return \Net\Bazzline\Component\Lock\FileHandlerLock
     */
    private function getNewLock()
    {
        $lock = new FileHandlerLock();
        $lock->setResource($this->fileHandler);

        return $lock;
    }
}