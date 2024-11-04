<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029084538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_support (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT NOT NULL, ref_admin_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, reponse LONGTEXT DEFAULT NULL, INDEX IDX_8ED83EB8637A8045 (ref_user_id), INDEX IDX_8ED83EB8E23C4497 (ref_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8E23C4497 FOREIGN KEY (ref_admin_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8637A8045');
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8E23C4497');
        $this->addSql('DROP TABLE question_support');
    }
}
