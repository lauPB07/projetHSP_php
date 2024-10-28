<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010092217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD ref_user_creer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FD5B118B2 FOREIGN KEY (ref_user_creer_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FD5B118B2 ON offre (ref_user_creer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FD5B118B2');
        $this->addSql('DROP INDEX IDX_AF86866FD5B118B2 ON offre');
        $this->addSql('ALTER TABLE offre DROP ref_user_creer_id');
    }
}
