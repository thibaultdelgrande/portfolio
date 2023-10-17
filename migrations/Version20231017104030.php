<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017104030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_link ADD id INT AUTO_INCREMENT NOT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_link MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON project_link');
        $this->addSql('ALTER TABLE project_link DROP id, CHANGE platform_id platform_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_link ADD PRIMARY KEY (project_id, platform_id)');
    }
}
