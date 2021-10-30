<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516130337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE especialista ADD credentials_id INT DEFAULT NULL, CHANGE town_id town_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL, CHANGE new new TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE especialista ADD CONSTRAINT FK_F206C39741E8B2E5 FOREIGN KEY (credentials_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F206C39741E8B2E5 ON especialista (credentials_id)');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE especialista DROP FOREIGN KEY FK_F206C39741E8B2E5');
        $this->addSql('DROP INDEX UNIQ_F206C39741E8B2E5 ON especialista');
        $this->addSql('ALTER TABLE especialista DROP credentials_id, CHANGE town_id town_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\', CHANGE new new TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
    }
}
