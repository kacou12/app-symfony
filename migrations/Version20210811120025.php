<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811120025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, author VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_23A0E66989D9B62 (slug), INDEX IDX_23A0E66BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_497DD634989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_article (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F1496C767294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_video (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D55D42DD29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) DEFAULT NULL, slug VARCHAR(100) NOT NULL, author VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7CC7DA2C989D9B62 (slug), INDEX IDX_7CC7DA2CBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE comment_article ADD CONSTRAINT FK_F1496C767294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment_video ADD CONSTRAINT FK_D55D42DD29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_article DROP FOREIGN KEY FK_F1496C767294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBCF5E72D');
        $this->addSql('ALTER TABLE comment_video DROP FOREIGN KEY FK_D55D42DD29C1004E');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE comment_article');
        $this->addSql('DROP TABLE comment_video');
        $this->addSql('DROP TABLE video');
    }
}
