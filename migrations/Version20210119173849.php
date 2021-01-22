<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119173849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, rue VARCHAR(1) NOT NULL, num_rue INT NOT NULL, code_post INT NOT NULL, ville VARCHAR(1) NOT NULL, INDEX IDX_C35F0816A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, designation VARCHAR(1) NOT NULL, age_min INT NOT NULL, prix_moyen DOUBLE PRECISION NOT NULL, INDEX IDX_3D213460BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom_prenom VARCHAR(1) NOT NULL, sexe VARCHAR(1) NOT NULL, date_nais DATETIME NOT NULL, INDEX IDX_FCEC9EF4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_cadeau (personne_id INT NOT NULL, cadeau_id INT NOT NULL, INDEX IDX_95B0C8DA21BD112 (personne_id), INDEX IDX_95B0C8DD9D5ED84 (cadeau_id), PRIMARY KEY(personne_id, cadeau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE cadeau ADD CONSTRAINT FK_3D213460BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE personne_cadeau ADD CONSTRAINT FK_95B0C8DA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_cadeau ADD CONSTRAINT FK_95B0C8DD9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF4DE7DC5C');
        $this->addSql('ALTER TABLE personne_cadeau DROP FOREIGN KEY FK_95B0C8DD9D5ED84');
        $this->addSql('ALTER TABLE cadeau DROP FOREIGN KEY FK_3D213460BCF5E72D');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A21BD112');
        $this->addSql('ALTER TABLE personne_cadeau DROP FOREIGN KEY FK_95B0C8DA21BD112');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_cadeau');
    }
}
