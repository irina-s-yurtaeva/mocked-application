<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903073434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_client ADD application_token VARCHAR(255) DEFAULT NULL, ADD scope VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE app_client_access_token DROP application_token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_client DROP application_token, DROP scope');
        $this->addSql('ALTER TABLE app_client_access_token ADD application_token VARCHAR(255) DEFAULT NULL');
    }
}
