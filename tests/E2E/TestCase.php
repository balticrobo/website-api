<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\E2E;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\StringInput;

class TestCase extends KernelTestCase
{
    /** @var Application */
    protected $application;

    protected static function rebootApp(): void
    {
        static::bootKernel();
    }

    protected function getContainer(): ContainerInterface
    {
        if (null === self::$kernel) {
            self::rebootApp();
        }

        return self::$container;
    }

    protected function runCommand(string $command, bool $checkResult = true): void
    {
        $result = $this->getApplication()->run(new StringInput(sprintf('%s --quiet', $command)));
        if (0 !== $result && $checkResult) {
            throw new \Exception("Command {$command} failed with status {$result}.");
        }
    }

    private function getApplication(): Application
    {
        if (null === static::$kernel) {
            self::rebootApp();
        }
        if (null === $this->application) {
            $this->application = new Application(static::$kernel);
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }
}
