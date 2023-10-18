<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018132255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_song (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, album_id INT NOT NULL, duration INT NOT NULL, version VARCHAR(255) DEFAULT NULL, INDEX IDX_57E658E1A0BDB2F3 (song_id), INDEX IDX_57E658E11137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_song ADD CONSTRAINT FK_57E658E1A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE album_song ADD CONSTRAINT FK_57E658E11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_song DROP FOREIGN KEY FK_57E658E1A0BDB2F3');
        $this->addSql('ALTER TABLE album_song DROP FOREIGN KEY FK_57E658E11137ABCF');
        $this->addSql('DROP TABLE album_song');
    }
}
