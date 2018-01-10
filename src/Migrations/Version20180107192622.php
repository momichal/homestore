<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180107192622 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_CF8382774A7E4868');
        $this->addSql('CREATE TEMPORARY TABLE __temp__buy AS SELECT id, sale_id, created_at, update_at FROM buy');
        $this->addSql('DROP TABLE buy');
        $this->addSql('CREATE TABLE buy (id INTEGER NOT NULL, sale_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_CF8382774A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO buy (id, sale_id, created_at, update_at) SELECT id, sale_id, created_at, update_at FROM __temp__buy');
        $this->addSql('DROP TABLE __temp__buy');
        $this->addSql('CREATE INDEX IDX_CF8382774A7E4868 ON buy (sale_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_CF8382774A7E4868');
        $this->addSql('CREATE TEMPORARY TABLE __temp__buy AS SELECT id, sale_id, created_at, update_at FROM buy');
        $this->addSql('DROP TABLE buy');
        $this->addSql('CREATE TABLE buy (id INTEGER NOT NULL, sale_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO buy (id, sale_id, created_at, update_at) SELECT id, sale_id, created_at, update_at FROM __temp__buy');
        $this->addSql('DROP TABLE __temp__buy');
        $this->addSql('CREATE INDEX IDX_CF8382774A7E4868 ON buy (sale_id)');
    }
}
