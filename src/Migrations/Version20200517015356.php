<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517015356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE especialista DROP firstname, DROP lastname, CHANGE town_id town_id INT DEFAULT NULL, CHANGE credentials_id credentials_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL, CHANGE new new TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE especialista ADD firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE town_id town_id INT DEFAULT NULL, CHANGE credentials_id credentials_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\', CHANGE new new TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
    }
}
