<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113150850 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actividades CHANGE lugar lugar VARCHAR(100) DEFAULT NULL, CHANGE fecha fecha DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE miembros CHANGE apellido apellido VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(50) DEFAULT NULL, CHANGE telefono telefono VARCHAR(50) DEFAULT NULL, CHANGE direccon direccon VARCHAR(200) DEFAULT NULL, CHANGE id_usuario id_usuario INT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actividades CHANGE lugar lugar VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE miembros CHANGE apellido apellido VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE telefono telefono VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE direccon direccon VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE id_usuario id_usuario INT NOT NULL');
    }
}
