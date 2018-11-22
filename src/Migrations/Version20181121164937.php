<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20181121164937 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE users (
            id INT AUTO_INCREMENT NOT NULL,
            forename VARCHAR(30) NOT NULL,
            surname VARCHAR(50) NOT NULL,
            email_address VARCHAR(255) NOT NULL,
            password VARCHAR(95) NOT NULL,
            roles JSON NOT NULL,
            active TINYINT(1) NOT NULL,
            created_at INT NOT NULL,
            UNIQUE INDEX UNIQ_1483A5E9B08E074E (email_address),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE users');
    }
}
