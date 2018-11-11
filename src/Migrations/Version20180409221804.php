<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180409221804 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE rules (
            id INT AUTO_INCREMENT NOT NULL,
            event_competition_id INT DEFAULT NULL,
            content LONGTEXT NOT NULL,
            locale VARCHAR(2) NOT NULL,
            last_update_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_899A993CA47D6561 (event_competition_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (
            id INT AUTO_INCREMENT NOT NULL,
            year VARCHAR(4) NOT NULL,
            event_starts_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            registration_starts_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            registration_ends_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            draft TINYINT(1) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_competitions (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            competition_id INT DEFAULT NULL,
            INDEX IDX_4ACE4CCE71F7E88B (event_id),
            INDEX IDX_4ACE4CCE7B39D312 (competition_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_groups (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(32) NOT NULL,
            slug VARCHAR(32) NOT NULL,
            visible_as_tile TINYINT(1) NOT NULL,
            tile_order SMALLINT DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competitions (
            id INT AUTO_INCREMENT NOT NULL,
            group_id INT DEFAULT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            registration_type SMALLINT NOT NULL,
            INDEX IDX_A7DD463DFE54D947 (group_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rules 
            ADD CONSTRAINT FK_899A993CA47D6561 
            FOREIGN KEY (event_competition_id) 
            REFERENCES event_competitions (id)');
        $this->addSql('ALTER TABLE event_competitions 
            ADD CONSTRAINT FK_4ACE4CCE71F7E88B 
            FOREIGN KEY (event_id) 
            REFERENCES events (id)');
        $this->addSql('ALTER TABLE event_competitions 
            ADD CONSTRAINT FK_4ACE4CCE7B39D312 
            FOREIGN KEY (competition_id) 
            REFERENCES competitions (id)');
        $this->addSql('ALTER TABLE competitions 
            ADD CONSTRAINT FK_A7DD463DFE54D947 
            FOREIGN KEY (group_id) 
            REFERENCES competition_groups (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_competitions
            DROP FOREIGN KEY FK_4ACE4CCE71F7E88B');
        $this->addSql('ALTER TABLE rules
            DROP FOREIGN KEY FK_899A993CA47D6561');
        $this->addSql('ALTER TABLE competitions
            DROP FOREIGN KEY FK_A7DD463DFE54D947');
        $this->addSql('ALTER TABLE event_competitions
            DROP FOREIGN KEY FK_4ACE4CCE7B39D312');
        $this->addSql('DROP TABLE rules');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE event_competitions');
        $this->addSql('DROP TABLE competition_groups');
        $this->addSql('DROP TABLE competitions');
    }
}
