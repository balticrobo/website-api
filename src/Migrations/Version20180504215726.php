<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180504215726 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE registration_constructions_creators (
            construction_id INT NOT NULL,
            creator_id INT NOT NULL,
            INDEX IDX_BD821306CF48117A (construction_id),
            INDEX IDX_BD82130661220EA6 (creator_id),
            PRIMARY KEY(construction_id, creator_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_constructions_creators
          ADD CONSTRAINT FK_BD821306CF48117A FOREIGN KEY (construction_id) REFERENCES registration_constructions (id)');
        $this->addSql('ALTER TABLE registration_constructions_creators
          ADD CONSTRAINT FK_BD82130661220EA6 FOREIGN KEY (creator_id) REFERENCES registration_members (id)');
        $this->addSql('ALTER TABLE registration_constructions DROP FOREIGN KEY FK_2D77EAC7D8A599F6');
        $this->addSql('DROP INDEX IDX_2D77EAC7D8A599F6 ON registration_constructions');
        $this->addSql('ALTER TABLE registration_constructions DROP creators_id');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE registration_constructions_creators');
        $this->addSql('ALTER TABLE registration_constructions ADD creators_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_constructions
          ADD CONSTRAINT FK_2D77EAC7D8A599F6 FOREIGN KEY (creators_id) REFERENCES registration_members (id)');
        $this->addSql('CREATE INDEX IDX_2D77EAC7D8A599F6 ON registration_constructions (creators_id)');
    }
}
