<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512110316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(180) NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
    }
}
