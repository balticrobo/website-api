<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180516225049 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE event_partners (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            file_id INT DEFAULT NULL,
            name VARCHAR(140) NOT NULL,
            url VARCHAR(250) NOT NULL,
            type SMALLINT NOT NULL,
            sort_order SMALLINT NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            INDEX IDX_A907B8B471F7E88B (event_id),
            INDEX IDX_A907B8B493CB796C (file_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_partners
          ADD CONSTRAINT FK_A907B8B471F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE event_partners
          ADD CONSTRAINT FK_A907B8B493CB796C FOREIGN KEY (file_id) REFERENCES storage_files (id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE event_partners');
    }
}
