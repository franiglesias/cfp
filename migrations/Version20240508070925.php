<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508070925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE proposal (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, sponsored BOOLEAN NOT NULL, location VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, received_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN proposal.received_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE proposal');
    }
}
