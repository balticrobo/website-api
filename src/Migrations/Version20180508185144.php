<?php declare(strict_types = 1);

namespace BalticRobo\Migrations;

use BalticRobo\Api\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180508185144 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D77EAC75E237E06296CD8AE
          ON registration_constructions (name, team_id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP INDEX UNIQ_2D77EAC75E237E06296CD8AE ON registration_constructions');
    }
}
