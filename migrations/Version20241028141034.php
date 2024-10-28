<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241028141034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_support (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, reponse LONGTEXT DEFAULT NULL, INDEX IDX_8ED83EB8637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user ADD question_support_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64964C12B8D FOREIGN KEY (question_support_id) REFERENCES question_support (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64964C12B8D ON user (question_support_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64964C12B8D');
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8637A8045');
        $this->addSql('DROP TABLE question_support');
        $this->addSql('DROP INDEX IDX_8D93D64964C12B8D ON `user`');
        $this->addSql('ALTER TABLE `user` DROP question_support_id');
    }
}
