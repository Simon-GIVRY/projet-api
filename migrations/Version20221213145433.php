<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213145433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts ADD text_content VARCHAR(255) DEFAULT NULL, ADD url_linked_media VARCHAR(255) DEFAULT NULL, DROP textContent, DROP urlLinkedMedia, CHANGE isPublished is_published TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts ADD textContent VARCHAR(255) DEFAULT NULL, ADD urlLinkedMedia VARCHAR(255) DEFAULT NULL, DROP text_content, DROP url_linked_media, CHANGE is_published isPublished TINYINT(1) NOT NULL');
    }
}
