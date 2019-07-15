<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190613160323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_objet CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_categorie CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_image CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE film ADD souscategorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22A27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie_film (id)');
        $this->addSql('CREATE INDEX IDX_8244BE22A27126E0 ON film (souscategorie_id)');
        $this->addSql('ALTER TABLE langue CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE menu CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE referencement CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slide CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_historique CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_newsletter CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_reinitialisation CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_objet CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22A27126E0');
        $this->addSql('DROP INDEX IDX_8244BE22A27126E0 ON film');
        $this->addSql('ALTER TABLE film DROP souscategorie_id');
        $this->addSql('ALTER TABLE galerieimage CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_categorie CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_image CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE langue CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE menu CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE referencement CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slide CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_historique CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_newsletter CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_reinitialisation CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
    }
}
