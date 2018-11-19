<?php declare(strict_types=1);

namespace BalticRobo\Api\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Client;

class WebTestCase extends TestCase
{
    protected function createClient(array $server = []): Client
    {
        $server['HTTPS'] = true;
        $server['HTTP_HOST'] = 'api.bbr.local';
        $client = $this->getKernel()->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

    protected function getResponseFile(string $filename): string
    {
        return __DIR__ . "/files/responses/{$filename}";
    }
}
