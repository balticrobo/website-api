<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180516164941 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE events
          ADD registration_stops_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE events DROP registration_stops_at');
    }
}
