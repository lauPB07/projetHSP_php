<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923131411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD ref_entreprise_id INT DEFAULT NULL, ADD ref_spe_id INT DEFAULT NULL, ADD ref_hopital_id INT DEFAULT NULL, ADD ref_role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64980FEF88A FOREIGN KEY (ref_entreprise_id) REFERENCES fiche_entreprise (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64925474DE9 FOREIGN KEY (ref_spe_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CACA508C FOREIGN KEY (ref_hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491217717C FOREIGN KEY (ref_role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64980FEF88A ON user (ref_entreprise_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64925474DE9 ON user (ref_spe_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CACA508C ON user (ref_hopital_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491217717C ON user (ref_role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64980FEF88A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64925474DE9');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CACA508C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491217717C');
        $this->addSql('DROP INDEX IDX_8D93D64980FEF88A ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D64925474DE9 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649CACA508C ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D6491217717C ON `user`');
        $this->addSql('ALTER TABLE `user` DROP ref_entreprise_id, DROP ref_spe_id, DROP ref_hopital_id, DROP ref_role_id');
    }
}