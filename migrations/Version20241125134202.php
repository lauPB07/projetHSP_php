<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125134202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8741C8393');
        $this->addSql('DROP INDEX IDX_8ED83EB8741C8393 ON question_support');
        $this->addSql('ALTER TABLE question_support ADD ref_user_id INT NOT NULL, CHANGE question_supports_id ref_admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8637A8045 FOREIGN KEY (ref_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8E23C4497 FOREIGN KEY (ref_admin_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_8ED83EB8637A8045 ON question_support (ref_user_id)');
        $this->addSql('CREATE INDEX IDX_8ED83EB8E23C4497 ON question_support (ref_admin_id)');
        $this->addSql('ALTER TABLE reponse ADD ref_post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC78F9D50FC FOREIGN KEY (ref_post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC78F9D50FC ON reponse (ref_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8637A8045');
        $this->addSql('ALTER TABLE question_support DROP FOREIGN KEY FK_8ED83EB8E23C4497');
        $this->addSql('DROP INDEX IDX_8ED83EB8637A8045 ON question_support');
        $this->addSql('DROP INDEX IDX_8ED83EB8E23C4497 ON question_support');
        $this->addSql('ALTER TABLE question_support DROP ref_user_id, CHANGE ref_admin_id question_supports_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_support ADD CONSTRAINT FK_8ED83EB8741C8393 FOREIGN KEY (question_supports_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8ED83EB8741C8393 ON question_support (question_supports_id)');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC78F9D50FC');
        $this->addSql('DROP INDEX IDX_5FB6DEC78F9D50FC ON reponse');
        $this->addSql('ALTER TABLE reponse DROP ref_post_id');
    }
}
