<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923131702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD ref_post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC78F9D50FC FOREIGN KEY (ref_post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC78F9D50FC ON reponse (ref_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC78F9D50FC');
        $this->addSql('DROP INDEX IDX_5FB6DEC78F9D50FC ON reponse');
        $this->addSql('ALTER TABLE reponse DROP ref_post_id');
    }
}
