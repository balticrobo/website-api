<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180605221203 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE registration_surveys (
            id INT AUTO_INCREMENT NOT NULL,
            event_id INT DEFAULT NULL,
            type SMALLINT NOT NULL,
            survey JSON NOT NULL,
            created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
            created_by_id INT DEFAULT NULL,
            INDEX IDX_EFD97B0171F7E88B (event_id),
            INDEX IDX_EFD97B01B03A8386 (created_by_id),
            UNIQUE INDEX UNIQ_EFD97B018CDE572971F7E88BB03A8386 (type, event_id, created_by_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_surveys
          ADD CONSTRAINT FK_EFD97B0171F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE registration_surveys
          ADD CONSTRAINT FK_EFD97B01B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE registration_surveys');
    }
}
