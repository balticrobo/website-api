<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181208160025 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, display_name VARCHAR(64) NOT NULL, name VARCHAR(64) NOT NULL, year SMALLINT NOT NULL, registration_type SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json_collection)\', CHANGE created_at created_at INT NOT NULL COMMENT \'(DC2Type:timestamp_immutable)\', CHANGE last_login_at last_login_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE competition');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at INT NOT NULL, CHANGE last_login_at last_login_at INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }
}
