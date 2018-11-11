<?php declare(strict_types=1);

namespace BalticRobo\Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration as DoctrineMigration;

abstract class AbstractMigration extends DoctrineMigration
{
    public function preUp(Schema $schema): void
    {
        $this->checkDatabaseType();
    }

    public function preDown(Schema $schema): void
    {
        $this->checkDatabaseType();
    }

    private function checkDatabaseType(): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'MySQL only!');
    }
}
