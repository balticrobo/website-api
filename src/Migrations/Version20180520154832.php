<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180520154832 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_constructions_competitions
          ADD presence_checked_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
          ADD tech_validated_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
        $this->addSql('ALTER TABLE registration_members
          ADD presence_checked_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
          ADD shirt_given_out_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_constructions_competitions
          DROP presence_checked_at,
          DROP tech_validated_at');
        $this->addSql('ALTER TABLE registration_members
          DROP presence_checked_at,
          DROP shirt_given_out_at');
    }
}
