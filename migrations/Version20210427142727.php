<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427142727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exception (id INT AUTO_INCREMENT NOT NULL, request_url VARCHAR(255) NOT NULL, request_method VARCHAR(255) NOT NULL, code INT DEFAULT NULL, message LONGTEXT NOT NULL, occured_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal (id INT AUTO_INCREMENT NOT NULL, proposed_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, last_updated_at DATETIME NOT NULL, INDEX IDX_BFE59472DAB5A938 (proposed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal_user (proposal_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_ADF2C332F4792058 (proposal_id), INDEX IDX_ADF2C332A76ED395 (user_id), PRIMARY KEY(proposal_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, request_url VARCHAR(255) NOT NULL, request_method VARCHAR(255) NOT NULL, requested_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, force_password_change TINYINT(1) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposal ADD CONSTRAINT FK_BFE59472DAB5A938 FOREIGN KEY (proposed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proposal_user ADD CONSTRAINT FK_ADF2C332F4792058 FOREIGN KEY (proposal_id) REFERENCES proposal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposal_user ADD CONSTRAINT FK_ADF2C332A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposal_user DROP FOREIGN KEY FK_ADF2C332F4792058');
        $this->addSql('ALTER TABLE proposal DROP FOREIGN KEY FK_BFE59472DAB5A938');
        $this->addSql('ALTER TABLE proposal_user DROP FOREIGN KEY FK_ADF2C332A76ED395');
        $this->addSql('DROP TABLE exception');
        $this->addSql('DROP TABLE proposal');
        $this->addSql('DROP TABLE proposal_user');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE user');
    }
}
