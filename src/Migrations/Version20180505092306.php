<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180505092306 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE registration_members_hackathon (
            id INT AUTO_INCREMENT NOT NULL,
            team_id INT DEFAULT NULL,
            forename VARCHAR(30) NOT NULL,
            surname VARCHAR(40) NOT NULL,
            age SMALLINT NOT NULL,
            shirt_type SMALLINT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_191CCE73296CD8AE (team_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_teams_hackathon (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            created_by_id INT DEFAULT NULL,
            name VARCHAR(50) NOT NULL,
            city VARCHAR(30) NOT NULL,
            why_you LONGTEXT NOT NULL,
            experience LONGTEXT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_F1BB96B171F7E88B (event_id),
            INDEX IDX_F1BB96B1B03A8386 (created_by_id),
            UNIQUE INDEX UNIQ_F1BB96B15E237E0671F7E88B (name, event_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_members_hackathon
          ADD CONSTRAINT FK_191CCE73296CD8AE FOREIGN KEY (team_id) REFERENCES registration_teams_hackathon (id)');
        $this->addSql('ALTER TABLE registration_teams_hackathon
          ADD CONSTRAINT FK_F1BB96B171F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE registration_teams_hackathon
          ADD CONSTRAINT FK_F1BB96B1B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_members_hackathon DROP FOREIGN KEY FK_191CCE73296CD8AE');
        $this->addSql('DROP TABLE registration_members_hackathon');
        $this->addSql('DROP TABLE registration_teams_hackathon');
    }
}
