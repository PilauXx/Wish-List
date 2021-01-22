<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120114821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse CHANGE rue rue VARCHAR(100) NOT NULL, CHANGE ville ville VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE cadeau CHANGE designation designation VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE personne CHANGE nom_prenom nom_prenom VARCHAR(100) NOT NULL, CHANGE sexe sexe VARCHAR(10) NOT NULL, CHANGE date_nais date_nais DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse CHANGE rue rue VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cadeau CHANGE designation designation VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personne CHANGE nom_prenom nom_prenom VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sexe sexe VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_nais date_nais DATETIME NOT NULL');
    }
}
