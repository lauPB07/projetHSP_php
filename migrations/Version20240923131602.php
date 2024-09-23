<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923131602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD ref_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7637A8045 ON reponse (ref_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7637A8045');
        $this->addSql('DROP INDEX IDX_5FB6DEC7637A8045 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP ref_user_id');
    }
}
