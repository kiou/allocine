<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190613153124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, objet_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, langue VARCHAR(8) NOT NULL, INDEX IDX_4C62E638F520CF5A (objet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_objet (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, email LONGTEXT NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerieimage_categorie (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerieimage (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, referencement_id INT DEFAULT NULL, filmgalerie_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, resume LONGTEXT NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, isActive TINYINT(1) NOT NULL, poid INT NOT NULL, langue VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_C017D875989D9B62 (slug), INDEX IDX_C017D875BCF5E72D (categorie_id), UNIQUE INDEX UNIQ_C017D8759039D8F0 (referencement_id), UNIQUE INDEX UNIQ_C017D875FB0369E5 (filmgalerie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerieimage_image (id INT AUTO_INCREMENT NOT NULL, galerie_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, isActive TINYINT(1) NOT NULL, poid INT NOT NULL, INDEX IDX_F10EB94F825396CB (galerie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, referencement_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, datedesortie DATETIME NOT NULL, synopsis LONGTEXT NOT NULL, ba LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, isActive TINYINT(1) NOT NULL, langue VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_8244BE22989D9B62 (slug), INDEX IDX_8244BE22BCF5E72D (categorie_id), UNIQUE INDEX UNIQ_8244BE229039D8F0 (referencement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_acteur (film_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_8108EE68567F5183 (film_id), INDEX IDX_8108EE68A21BD112 (personne_id), PRIMARY KEY(film_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_realisateur (film_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_3F2B13F1567F5183 (film_id), INDEX IDX_3F2B13F1A21BD112 (personne_id), PRIMARY KEY(film_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, lien VARCHAR(255) DEFAULT NULL, destination TINYINT(1) NOT NULL, isActive TINYINT(1) NOT NULL, parent INT NOT NULL, poid INT NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, referencement_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, contenu LONGTEXT NOT NULL, isActive TINYINT(1) NOT NULL, poid INT NOT NULL, langue VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), UNIQUE INDEX UNIQ_140AB6209039D8F0 (referencement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, referencement_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_FCEC9EF989D9B62 (slug), UNIQUE INDEX UNIQ_FCEC9EF9039D8F0 (referencement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referencement (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, ogtitle VARCHAR(255) DEFAULT NULL, ogdescription VARCHAR(255) DEFAULT NULL, ogurl VARCHAR(255) DEFAULT NULL, ogimage VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, slider_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, lien VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, isActive TINYINT(1) NOT NULL, poid INT NOT NULL, INDEX IDX_72EFEE622CCC9638 (slider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nickname VARCHAR(191) NOT NULL, username VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(191) NOT NULL, isActive TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_film (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, film_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created DATETIME NOT NULL, rating INT NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_67F068BC567F5183 (film_id), INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie_film (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_675A7CD4BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_historique (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, contenu LONGTEXT NOT NULL, ip VARCHAR(255) NOT NULL, INDEX IDX_4AD81300FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_newsletter (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, langue VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reinitialisation (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, changed DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, isActive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F520CF5A FOREIGN KEY (objet_id) REFERENCES contact_objet (id)');
        $this->addSql('ALTER TABLE galerieimage ADD CONSTRAINT FK_C017D875BCF5E72D FOREIGN KEY (categorie_id) REFERENCES galerieimage_categorie (id)');
        $this->addSql('ALTER TABLE galerieimage ADD CONSTRAINT FK_C017D8759039D8F0 FOREIGN KEY (referencement_id) REFERENCES referencement (id)');
        $this->addSql('ALTER TABLE galerieimage ADD CONSTRAINT FK_C017D875FB0369E5 FOREIGN KEY (filmgalerie_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE galerieimage_image ADD CONSTRAINT FK_F10EB94F825396CB FOREIGN KEY (galerie_id) REFERENCES galerieimage (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_film (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE229039D8F0 FOREIGN KEY (referencement_id) REFERENCES referencement (id)');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_realisateur ADD CONSTRAINT FK_3F2B13F1567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_realisateur ADD CONSTRAINT FK_3F2B13F1A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6209039D8F0 FOREIGN KEY (referencement_id) REFERENCES referencement (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF9039D8F0 FOREIGN KEY (referencement_id) REFERENCES referencement (id)');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE622CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE souscategorie_film ADD CONSTRAINT FK_675A7CD4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_film (id)');
        $this->addSql('ALTER TABLE user_historique ADD CONSTRAINT FK_4AD81300FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638F520CF5A');
        $this->addSql('ALTER TABLE galerieimage DROP FOREIGN KEY FK_C017D875BCF5E72D');
        $this->addSql('ALTER TABLE galerieimage_image DROP FOREIGN KEY FK_F10EB94F825396CB');
        $this->addSql('ALTER TABLE galerieimage DROP FOREIGN KEY FK_C017D875FB0369E5');
        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68567F5183');
        $this->addSql('ALTER TABLE film_realisateur DROP FOREIGN KEY FK_3F2B13F1567F5183');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC567F5183');
        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68A21BD112');
        $this->addSql('ALTER TABLE film_realisateur DROP FOREIGN KEY FK_3F2B13F1A21BD112');
        $this->addSql('ALTER TABLE galerieimage DROP FOREIGN KEY FK_C017D8759039D8F0');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE229039D8F0');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6209039D8F0');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF9039D8F0');
        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE622CCC9638');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE user_historique DROP FOREIGN KEY FK_4AD81300FB88E14F');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22BCF5E72D');
        $this->addSql('ALTER TABLE souscategorie_film DROP FOREIGN KEY FK_675A7CD4BCF5E72D');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_objet');
        $this->addSql('DROP TABLE galerieimage_categorie');
        $this->addSql('DROP TABLE galerieimage');
        $this->addSql('DROP TABLE galerieimage_image');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_acteur');
        $this->addSql('DROP TABLE film_realisateur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE referencement');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE categorie_film');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE souscategorie_film');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE user_historique');
        $this->addSql('DROP TABLE user_newsletter');
        $this->addSql('DROP TABLE user_reinitialisation');
    }
}
