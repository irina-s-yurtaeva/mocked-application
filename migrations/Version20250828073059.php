<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250828073059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_client (
		id INT AUTO_INCREMENT NOT NULL, 
		member_id VARCHAR(255) NOT NULL, 
		domain VARCHAR(255) NOT NULL, 
		client_endpoint VARCHAR(255) DEFAULT NULL, 
		UNIQUE INDEX UX_APP_CLIENT_MEMBER_ID (member_id), 
		PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`'
    );
        $this->addSql('CREATE TABLE app_client_access_token (
		id INT AUTO_INCREMENT NOT NULL, 
		client_id INT NOT NULL, 
		access_token VARCHAR(255) NOT NULL, 
		expires_in DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
		application_token VARCHAR(255) DEFAULT NULL, 
		refresh_token VARCHAR(255) DEFAULT NULL, 
		user_id INT DEFAULT NULL, 
		user_full_name VARCHAR(255) DEFAULT NULL, 
		INDEX IDX_APP_CLIENT_ACCESS_TOKEN_CLIENT_ID (client_id), 
		PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`'
    );
        $this->addSql('ALTER TABLE app_client_access_token ADD CONSTRAINT FK_591697AC19EB6921 FOREIGN KEY (client_id) REFERENCES app_client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_client_access_token DROP FOREIGN KEY FK_591697AC19EB6921');
        $this->addSql('DROP TABLE app_client');
        $this->addSql('DROP TABLE app_client_access_token');
    }
}
