<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010085928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_entreprise_offre DROP FOREIGN KEY FK_CA9009664CC8505A');
        $this->addSql('ALTER TABLE fiche_entreprise_offre DROP FOREIGN KEY FK_CA900966F241FBD4');
        $this->addSql('DROP TABLE fiche_entreprise_offre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche_entreprise_offre (fiche_entreprise_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_CA900966F241FBD4 (fiche_entreprise_id), INDEX IDX_CA9009664CC8505A (offre_id), PRIMARY KEY(fiche_entreprise_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fiche_entreprise_offre ADD CONSTRAINT FK_CA9009664CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_entreprise_offre ADD CONSTRAINT FK_CA900966F241FBD4 FOREIGN KEY (fiche_entreprise_id) REFERENCES fiche_entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
