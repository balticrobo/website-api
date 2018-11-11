<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180502055108 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE registration_members (
            id INT AUTO_INCREMENT NOT NULL,
            team_id INT DEFAULT NULL,
            forename VARCHAR(30) NOT NULL,
            surname VARCHAR(40) NOT NULL,
            shirt_type SMALLINT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_5D18759296CD8AE (team_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_teams (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            created_by_id INT DEFAULT NULL,
            name VARCHAR(50) NOT NULL,
            identifier VARCHAR(4) NOT NULL,
            city VARCHAR(30) NOT NULL,
            scientific_organization VARCHAR(30) NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_196882B071F7E88B (event_id),
            UNIQUE INDEX UNIQ_196882B0B03A8386 (created_by_id),
            UNIQUE INDEX UNIQ_196882B0772E836A71F7E88B (identifier,
            event_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_constructions (
            id INT AUTO_INCREMENT NOT NULL,
            team_id INT DEFAULT NULL,
            creators_id INT DEFAULT NULL,
            name VARCHAR(50) NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_2D77EAC7296CD8AE (team_id),
            INDEX IDX_2D77EAC7D8A599F6 (creators_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_constructions_competitions (
            construction_id INT NOT NULL,
            competition_id INT NOT NULL,
            INDEX IDX_520AB2E9CF48117A (construction_id),
            INDEX IDX_520AB2E97B39D312 (competition_id),
            PRIMARY KEY(construction_id,
            competition_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_members ADD CONSTRAINT FK_5D18759296CD8AE 
            FOREIGN KEY (team_id) REFERENCES registration_teams (id)');
        $this->addSql('ALTER TABLE registration_teams ADD CONSTRAINT FK_196882B071F7E88B 
            FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE registration_teams ADD CONSTRAINT FK_196882B0B03A8386 
            FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE registration_constructions ADD CONSTRAINT FK_2D77EAC7296CD8AE 
            FOREIGN KEY (team_id) REFERENCES registration_teams (id)');
        $this->addSql('ALTER TABLE registration_constructions ADD CONSTRAINT FK_2D77EAC7D8A599F6 
            FOREIGN KEY (creators_id) REFERENCES registration_members (id)');
        $this->addSql('ALTER TABLE registration_constructions_competitions ADD CONSTRAINT FK_520AB2E9CF48117A 
            FOREIGN KEY (construction_id) REFERENCES registration_constructions (id)');
        $this->addSql('ALTER TABLE registration_constructions_competitions ADD CONSTRAINT FK_520AB2E97B39D312 
            FOREIGN KEY (competition_id) REFERENCES competitions (id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE registration_constructions DROP FOREIGN KEY FK_2D77EAC7D8A599F6');
        $this->addSql('ALTER TABLE registration_members DROP FOREIGN KEY FK_5D18759296CD8AE');
        $this->addSql('ALTER TABLE registration_teams DROP FOREIGN KEY FK_196882B0B03A8386');
        $this->addSql('ALTER TABLE registration_constructions DROP FOREIGN KEY FK_2D77EAC7296CD8AE');
        $this->addSql('ALTER TABLE registration_constructions_competitions DROP FOREIGN KEY FK_520AB2E9CF48117A');
        $this->addSql('DROP TABLE registration_members');
        $this->addSql('DROP TABLE registration_teams');
        $this->addSql('DROP TABLE registration_constructions');
        $this->addSql('DROP TABLE registration_constructions_competitions');
    }
}
