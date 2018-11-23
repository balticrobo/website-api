<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\E2E;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;

class WebTestCase extends TestCase
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var Client */
    protected $client;

    protected function getResponseFile(string $filename): string
    {
        return __DIR__ . "/files/responses/{$filename}";
    }

    protected function setUp(): void
    {
        $this->client = $this->createClient();
        $this->runCommand('doctrine:database:drop --if-exists --force');
        $this->runCommand('doctrine:database:create');
        $this->runCommand('doctrine:migration:migrate --no-interaction');
        $this->entityManager = $this->createTransaction();
    }

    protected function tearDown(): void
    {
        $this->closeTransaction($this->entityManager);
        self::rebootApp();
    }

    private function createClient(): Client
    {
        $client = $this->getContainer()->get('test.client');
        $client->setServerParameters([
            'HTTPS' => true,
            'HTTP_HOST' => 'api.bbr.local',
        ]);

        return $client;
    }

    private function createTransaction(): EntityManagerInterface
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->beginTransaction();
        $em->getConnection()->setAutoCommit(false);

        return $em;
    }

    private function closeTransaction(EntityManagerInterface $em): void
    {
        if ($em->getConnection()->isTransactionActive()) {
            $em->rollback();
        }
    }
}
