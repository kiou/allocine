<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715122744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, referencement_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, debut DATETIME NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, resume LONGTEXT NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, isActive TINYINT(1) NOT NULL, poid INT NOT NULL, avant TINYINT(1) NOT NULL, langue VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_54928197989D9B62 (slug), UNIQUE INDEX UNIQ_549281979039D8F0 (referencement_id), INDEX IDX_54928197BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actualite_categorie (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281979039D8F0 FOREIGN KEY (referencement_id) REFERENCES referencement (id)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197BCF5E72D FOREIGN KEY (categorie_id) REFERENCES actualite_categorie (id)');
        $this->addSql('ALTER TABLE contact CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_objet CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_categorie CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieimage_image CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement_categorie CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL, CHANGE debut debut DATETIME NOT NULL, CHANGE fin fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE menu CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE referencement CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE slide CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE langue CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_historique CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_newsletter CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_reinitialisation CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197BCF5E72D');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE actualite_categorie');
        $this->addSql('ALTER TABLE contact CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_objet CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL, CHANGE debut debut DATETIME NOT NULL, CHANGE fin fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE evenement_categorie CHANGE created created DATETIME NOT NULL, CHANGE changed changed DATETIME DEFAULT NULL');
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
