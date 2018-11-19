<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class TestCase extends KernelTestCase
{
    private $application;

    protected function getKernel(): KernelInterface
    {
        static::bootKernel();

        return static::$kernel;
    }

    protected function getApplication(): Application
    {
        if (null === $this->application) {
            $this->application = new Application($this->getKernel());
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }
}
