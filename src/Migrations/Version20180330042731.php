<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180330042731 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE users (
            id INT AUTO_INCREMENT NOT NULL,
            forename VARCHAR(30) NOT NULL,
            surname VARCHAR(40) NOT NULL,
            email VARCHAR(80) NOT NULL,
            password VARCHAR(60) NOT NULL,
            active TINYINT(1) NOT NULL,
            roles JSON NOT NULL,
            created_at INT NOT NULL COMMENT '(DC2Type:timestamp_immutable)',
            last_login_at INT DEFAULT NULL COMMENT '(DC2Type:timestamp_immutable)',
            UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
