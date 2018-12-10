<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181209021833 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE events (
                id INT AUTO_INCREMENT NOT NULL,
                year VARCHAR(4) NOT NULL,
                event_starts_at INT NOT NULL,
                registration_starts_at INT NOT NULL,
                registration_stops_at INT NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE events');
    }
}
