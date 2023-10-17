<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017074843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_link (project_id INT NOT NULL, platform_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_F3D51E9166D1F9C (project_id), INDEX IDX_F3D51E9FFE6496F (platform_id), PRIMARY KEY(project_id, platform_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_link ADD CONSTRAINT FK_F3D51E9166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_link ADD CONSTRAINT FK_F3D51E9FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_link DROP FOREIGN KEY FK_F3D51E9166D1F9C');
        $this->addSql('ALTER TABLE project_link DROP FOREIGN KEY FK_F3D51E9FFE6496F');
        $this->addSql('DROP TABLE project_link');
    }
}
