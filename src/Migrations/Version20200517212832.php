<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517212832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sitio_patrimonial (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, tipositio_id INT DEFAULT NULL, provincia_id INT DEFAULT NULL, municipio_id INT DEFAULT NULL, codigo VARCHAR(80) NOT NULL, fecharegistro DATE NOT NULL, nombresitio VARCHAR(100) NOT NULL, longitud VARCHAR(255) NOT NULL, latitud VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_453A290E20332D99 (codigo), UNIQUE INDEX UNIQ_453A290E977383CC (nombresitio), UNIQUE INDEX UNIQ_453A290E8B35C311 (longitud), UNIQUE INDEX UNIQ_453A290E13C133E8 (latitud), INDEX IDX_453A290E3397707A (categoria_id), INDEX IDX_453A290EC0B6216D (tipositio_id), INDEX IDX_453A290E4E7121AF (provincia_id), INDEX IDX_453A290E58BC1BE0 (municipio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_proyecto (id INT AUTO_INCREMENT NOT NULL, nombretipositio VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_B9175870B5603CF (nombretipositio), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sitio_patrimonial ADD CONSTRAINT FK_453A290E3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sitio_patrimonial ADD CONSTRAINT FK_453A290EC0B6216D FOREIGN KEY (tipositio_id) REFERENCES tipo_sitio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sitio_patrimonial ADD CONSTRAINT FK_453A290E4E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sitio_patrimonial ADD CONSTRAINT FK_453A290E58BC1BE0 FOREIGN KEY (municipio_id) REFERENCES municipio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE especialista CHANGE town_id town_id INT DEFAULT NULL, CHANGE credentials_id credentials_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL, CHANGE new new TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sitio_patrimonial');
        $this->addSql('DROP TABLE tipo_proyecto');
        $this->addSql('ALTER TABLE especialista CHANGE town_id town_id INT DEFAULT NULL, CHANGE credentials_id credentials_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\', CHANGE new new TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE municipio CHANGE provincia_id provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE provincia CHANGE pais_id pais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
    }
}
