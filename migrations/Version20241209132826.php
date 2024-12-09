<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209132826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, rue VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, element_sup LONGTEXT DEFAULT NULL, date DATE NOT NULL, nb_place INT NOT NULL, nb_place_total INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_user (event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_92589AE271F7E88B (event_id), INDEX IDX_92589AE2A76ED395 (user_id), PRIMARY KEY(event_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_entreprise (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adresse_web VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_etablissement (id INT AUTO_INCREMENT NOT NULL, nom_etablissement VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adress_web VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopital (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, ref_type_offre_id INT DEFAULT NULL, ref_user_creer_id INT DEFAULT NULL, titre LONGTEXT NOT NULL, description LONGTEXT NOT NULL, mission_lier LONGTEXT NOT NULL, salaire DOUBLE PRECISION DEFAULT NULL, est_cloturer TINYINT(1) NOT NULL, INDEX IDX_AF86866FA56720C6 (ref_type_offre_id), INDEX IDX_AF86866FD5B118B2 (ref_user_creer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_fiche_entreprise (offre_id INT NOT NULL, fiche_entreprise_id INT NOT NULL, INDEX IDX_C47B6C6D4CC8505A (offre_id), INDEX IDX_C47B6C6DF241FBD4 (fiche_entreprise_id), PRIMARY KEY(offre_id, fiche_entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT DEFAULT NULL, canal VARCHAR(255) NOT NULL, titre LONGTEXT NOT NULL, contenue LONGTEXT NOT NULL, date DATE NOT NULL, INDEX IDX_5A8A6C8D637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_support (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT NOT NULL, ref_admin_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, reponse LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_8ED83EB8637A8045 (ref_user_id), INDEX IDX_8ED83EB8E23C4497 (ref_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, ref_post_id INT DEFAULT NULL, ref_user_id INT DEFAULT NULL, contenue VARCHAR(255) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, INDEX IDX_5FB6DEC78F9D50FC (ref_post_id), INDEX IDX_5FB6DEC7637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom_spe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, ref_entreprise_id INT DEFAULT NULL, ref_spe_id INT DEFAULT NULL, ref_hopital_id INT DEFAULT NULL, ref_role_id INT DEFAULT NULL, ref_etablissement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, cv LONGBLOB DEFAULT NULL, poste VARCHAR(255) DEFAULT NULL, valider TINYINT(1) NOT NULL, formation_etudiant VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D64980FEF88A (ref_entreprise_id), INDEX IDX_8D93D64925474DE9 (ref_spe_id), INDEX IDX_8D93D649CACA508C (ref_hopital_id), INDEX IDX_8D93D6491217717C (ref_role_id), INDEX IDX_8D93D6492925434B (ref_etablissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_offre (user_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_4D447D37A76ED395 (user_id), INDEX IDX_4D447D374CC8505A (offre_id), PRIMARY KEY(user_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA56720C6 FOREIGN KEY (ref_type_offre_id) REFERENCES type_offre (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FD5B118B2 FOREIGN KEY (ref_user_creer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE offre_fiche_entreprise ADD CONSTRAINT FK_C47B6C6D4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_fiche_entreprise ADD CONSTRAINT FK_C47B6C6DF241FBD4 FOREIGN KEY (fiche_entreprise_id) REFERENCES fiche_entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8E23C4497 FOREIGN KEY (ref_admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC78F9D50FC FOREIGN KEY (ref_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64980FEF88A FOREIGN KEY (ref_entreprise_id) REFERENCES fiche_entreprise (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64925474DE9 FOREIGN KEY (ref_spe_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649CACA508C FOREIGN KEY (ref_hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6491217717C FOREIGN KEY (ref_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6492925434B FOREIGN KEY (ref_etablissement_id) REFERENCES fiche_etablissement (id)');
        $this->addSql('ALTER TABLE user_offre ADD CONSTRAINT FK_4D447D37A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_offre ADD CONSTRAINT FK_4D447D374CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE271F7E88B');
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE2A76ED395');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA56720C6');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FD5B118B2');
        $this->addSql('ALTER TABLE offre_fiche_entreprise DROP FOREIGN KEY FK_C47B6C6D4CC8505A');
        $this->addSql('ALTER TABLE offre_fiche_entreprise DROP FOREIGN KEY FK_C47B6C6DF241FBD4');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D637A8045');
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8637A8045');
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8E23C4497');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC78F9D50FC');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7637A8045');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64980FEF88A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64925474DE9');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CACA508C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491217717C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6492925434B');
        $this->addSql('ALTER TABLE user_offre DROP FOREIGN KEY FK_4D447D37A76ED395');
        $this->addSql('ALTER TABLE user_offre DROP FOREIGN KEY FK_4D447D374CC8505A');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('DROP TABLE fiche_entreprise');
        $this->addSql('DROP TABLE fiche_etablissement');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_fiche_entreprise');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE question_support');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE type_offre');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_offre');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
