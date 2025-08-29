<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250828100722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_client ADD install_count INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE app_client RENAME INDEX ux_app_client_member_id TO UNIQ_224769D57597D3FE');
        $this->addSql('ALTER TABLE app_client_access_token RENAME INDEX idx_app_client_access_token_client_id TO IDX_591697AC19EB6921');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_client DROP install_count, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE app_client RENAME INDEX uniq_224769d57597d3fe TO UX_APP_CLIENT_MEMBER_ID');
        $this->addSql('ALTER TABLE app_client_access_token RENAME INDEX idx_591697ac19eb6921 TO IDX_APP_CLIENT_ACCESS_TOKEN_CLIENT_ID');
    }
}
