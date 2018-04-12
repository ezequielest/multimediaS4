<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113000039 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actividades_miembros (actividades_id INT NOT NULL, miembros_id INT NOT NULL, INDEX IDX_987ACF662F4F3E2F (actividades_id), INDEX IDX_987ACF6621043622 (miembros_id), PRIMARY KEY(actividades_id, miembros_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actividades_miembros ADD CONSTRAINT FK_987ACF662F4F3E2F FOREIGN KEY (actividades_id) REFERENCES actividades (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actividades_miembros ADD CONSTRAINT FK_987ACF6621043622 FOREIGN KEY (miembros_id) REFERENCES miembros (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE actividades_miembros');
    }
}
