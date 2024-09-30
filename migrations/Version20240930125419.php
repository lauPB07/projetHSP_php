<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930125419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post RENAME INDEX fk_5a8a6c8d637a8045 TO IDX_5A8A6C8D637A8045');
        $this->addSql('ALTER TABLE user ADD ref_etablissement_id INT DEFAULT NULL, ADD post_id INT NOT NULL, ADD reponse_id INT NOT NULL, ADD is_verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492925434B FOREIGN KEY (ref_etablissement_id) REFERENCES fiche_etablissement (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492925434B ON user (ref_etablissement_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494B89032C ON user (post_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CF18BB82 ON user (reponse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6492925434B');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494B89032C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CF18BB82');
        $this->addSql('DROP INDEX IDX_8D93D6492925434B ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D6494B89032C ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649CF18BB82 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP ref_etablissement_id, DROP post_id, DROP reponse_id, DROP is_verified');
        $this->addSql('ALTER TABLE post RENAME INDEX idx_5a8a6c8d637a8045 TO FK_5A8A6C8D637A8045');
    }
}
