<?php

namespace MockedApplication\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250723000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create client_settings table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
CREATE TABLE client_settings (
    id INT AUTO_INCREMENT NOT NULL,
    member_id VARCHAR(255) NOT NULL,
    access_token VARCHAR(255) NOT NULL,
    expires_in VARCHAR(255) NOT NULL,
    application_token VARCHAR(255) NOT NULL,
    refresh_token VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    client_endpoint VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE client_settings");
    }
}
