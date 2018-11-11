<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180505144017 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_teams_hackathon
          ADD captain_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_teams_hackathon
          ADD CONSTRAINT FK_F1BB96B13346729B FOREIGN KEY (captain_id) REFERENCES registration_members_hackathon (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F1BB96B13346729B
          ON registration_teams_hackathon (captain_id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_teams_hackathon DROP FOREIGN KEY FK_F1BB96B13346729B');
        $this->addSql('DROP INDEX UNIQ_F1BB96B13346729B ON registration_teams_hackathon');
        $this->addSql('ALTER TABLE registration_teams_hackathon DROP captain_id');
    }
}
