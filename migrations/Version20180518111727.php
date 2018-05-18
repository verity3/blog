<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180518111727 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_63540598C9F3610 (file), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, postTitle VARCHAR(150) NOT NULL, newsPostDate DATETIME NOT NULL, newsPostText LONGTEXT NOT NULL, active TINYINT(1) DEFAULT \'0\' NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, createdBy INT DEFAULT NULL, INDEX IDX_1DD39950D3564642 (createdBy), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_post_files (news_post_id INT NOT NULL, files_id INT NOT NULL, INDEX IDX_7D511BCF1C6D1FCA (news_post_id), INDEX IDX_7D511BCFA3E65B2F (files_id), PRIMARY KEY(news_post_id, files_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', active TINYINT(1) DEFAULT \'0\' NOT NULL, password_temp VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, remember_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950D3564642 FOREIGN KEY (createdBy) REFERENCES users (id)');
        $this->addSql('ALTER TABLE news_post_files ADD CONSTRAINT FK_7D511BCF1C6D1FCA FOREIGN KEY (news_post_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_post_files ADD CONSTRAINT FK_7D511BCFA3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_post_files DROP FOREIGN KEY FK_7D511BCFA3E65B2F');
        $this->addSql('ALTER TABLE news_post_files DROP FOREIGN KEY FK_7D511BCF1C6D1FCA');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950D3564642');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_post_files');
        $this->addSql('DROP TABLE users');
    }
}
