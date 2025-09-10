<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910062831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_224769D5BCA34641 ON app_client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_224769D57597D3FE ON app_client (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_224769D57597D3FE ON app_client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_224769D5BCA34641 ON app_client (application_token)');
    }
}
