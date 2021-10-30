<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200515121254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE especialista (id INT AUTO_INCREMENT NOT NULL, town_id INT DEFAULT NULL, no_reg BIGINT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, no_id INT NOT NULL, state TINYINT(1) DEFAULT NULL, new TINYINT(1) DEFAULT NULL, INDEX IDX_F206C39775E23604 (town_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE especialista ADD CONSTRAINT FK_F206C39775E23604 FOREIGN KEY (town_id) REFERENCES municipio (id)');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE especialista');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
    }
}
