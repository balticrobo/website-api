<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180517231530 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE events
          MODIFY COLUMN registration_stops_at int(11) NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'
            AFTER registration_starts_at');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE events
          MODIFY COLUMN registration_stops_at int(11) NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'
            AFTER draft');
    }
}
