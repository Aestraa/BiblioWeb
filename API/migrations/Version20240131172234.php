<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131172234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, date_adhesion DATE NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naiss DATE NOT NULL, email VARCHAR(255) NOT NULL, adresse_postale VARCHAR(255) NOT NULL, num_tel VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, date_deces DATE NOT NULL, nationalite VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur_livre (auteur_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_A6DFA5E060BB6FE6 (auteur_id), INDEX IDX_A6DFA5E037D925CB (livre_id), PRIMARY KEY(auteur_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_livre (categorie_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_591BA249BCF5E72D (categorie_id), INDEX IDX_591BA24937D925CB (livre_id), PRIMARY KEY(categorie_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, correspondre_id INT DEFAULT NULL, date_emprunt DATE NOT NULL, date_retour DATE NOT NULL, INDEX IDX_364071D7D793666D (correspondre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt_adherent (emprunt_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_38A79937AE7FEF94 (emprunt_id), INDEX IDX_38A7993725F06C53 (adherent_id), PRIMARY KEY(emprunt_id, adherent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, langue VARCHAR(255) NOT NULL, photo_couverture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, faire_id INT DEFAULT NULL, lier_id INT DEFAULT NULL, date_resa DATE NOT NULL, date_resa_fin DATE NOT NULL, INDEX IDX_4DA2396776C72A (faire_id), UNIQUE INDEX UNIQ_4DA239F7652B75 (lier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auteur_livre ADD CONSTRAINT FK_A6DFA5E060BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auteur_livre ADD CONSTRAINT FK_A6DFA5E037D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_livre ADD CONSTRAINT FK_591BA249BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_livre ADD CONSTRAINT FK_591BA24937D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7D793666D FOREIGN KEY (correspondre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE emprunt_adherent ADD CONSTRAINT FK_38A79937AE7FEF94 FOREIGN KEY (emprunt_id) REFERENCES emprunt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_adherent ADD CONSTRAINT FK_38A7993725F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2396776C72A FOREIGN KEY (faire_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239F7652B75 FOREIGN KEY (lier_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur_livre DROP FOREIGN KEY FK_A6DFA5E060BB6FE6');
        $this->addSql('ALTER TABLE auteur_livre DROP FOREIGN KEY FK_A6DFA5E037D925CB');
        $this->addSql('ALTER TABLE categorie_livre DROP FOREIGN KEY FK_591BA249BCF5E72D');
        $this->addSql('ALTER TABLE categorie_livre DROP FOREIGN KEY FK_591BA24937D925CB');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7D793666D');
        $this->addSql('ALTER TABLE emprunt_adherent DROP FOREIGN KEY FK_38A79937AE7FEF94');
        $this->addSql('ALTER TABLE emprunt_adherent DROP FOREIGN KEY FK_38A7993725F06C53');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2396776C72A');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239F7652B75');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE auteur_livre');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_livre');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE emprunt_adherent');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
