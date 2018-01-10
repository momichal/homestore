<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180107193143 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE buy (id INTEGER NOT NULL, sale_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CF8382774A7E4868 ON buy (sale_id)');
        $this->addSql('CREATE TABLE sale (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, image CLOB NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, status VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE buy');
        $this->addSql('DROP TABLE sale');
    }
}
