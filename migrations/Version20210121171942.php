<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210121171942 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A21BD112');
        $this->addSql('DROP INDEX IDX_C35F0816A21BD112 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP personne_id');
        $this->addSql('ALTER TABLE personne CHANGE date_nais date_nais DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD personne_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_C35F0816A21BD112 ON adresse (personne_id)');
        $this->addSql('ALTER TABLE personne CHANGE date_nais date_nais DATE NOT NULL');
    }
}
