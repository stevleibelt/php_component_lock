<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2013-06-30 
 */

namespace Test\Net\Bazzline\Component\Lock;

use Net\Bazzline\Component\Lock\FileNameLock;
use Net\Bazzline\Component\Lock\LockInterface;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use ReflectionClass;

/**
 * Class FileLockTest
 *
 * @package Test\Net\Bazzline\Component\Lock
 */
class FileLockTest extends PHPUnit_Framework_TestCase
{
    /** @var string */
    private $lockFilePath;

    protected function setUp()
    {
        //@todo use vfsStream
        $this->lockFilePath = '/tmp/' . str_replace('\\', '_', get_class($this));
    }

    protected function tearDown()
    {
        $this->releaseLock();
    }

    public function testShutdownInterfaceImplemented()
    {
        $className  = get_class($this->getNewLock());
        $reflection = new ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface(LockInterface::class));
    }

    public function testGetAndSetResource()
    {
        $lock = $this->getNewLock(false);

        $this->assertTrue((strlen($lock->getResource()) > 0));
        $lock->setResource($this->lockFilePath);
        $this->assertEquals($this->lockFilePath . '.lock', $lock->getResource());
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
     */
    public function testLock_withExistingLock()
    {
        $this->acquireLock();
        $lock = $this->getNewLock();

        $this->assertTrue($lock->isLocked());
        $lock->acquire();
    }

    public function testUnlock_withExistingLock()
    {
        $this->acquireLock();
        $lock = $this->getNewLock();

        $this->assertTrue($lock->isLocked());
        $lock->release();
        $this->assertFalse($lock->isLocked());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnlock_withNoExistingLock()
    {
        $lock = $this->getNewLock();

        $this->assertFalse($lock->isLocked());
        $lock->release();
    }

    public function testProcessIdInTheLockFile()
    {
        $lock = $this->getNewLock();
        $lock->acquire();

        $expectedLockFileContent    = 'process id: ' . getmypid();
        $lockFileContent            = file_get_contents($lock->getResource());

        $this->assertEquals($expectedLockFileContent, $lockFileContent);
    }

    private function acquireLock()
    {
        touch ($this->lockFilePath . '.lock');
    }

    private function releaseLock()
    {
        $lockFileName = $this->lockFilePath . '.lock';

        if (file_exists($lockFileName)) {
            unlink ($lockFileName);
        }
    }

    /**
     * @param boolean $setResource
     * @return \Net\Bazzline\Component\Lock\FileNameLock
     */
    private function getNewLock($setResource = true)
    {
        $lock = new FileNameLock();
        if ($setResource) {
            $lock->setResource($this->lockFilePath);
        }

        return $lock;
    }
}