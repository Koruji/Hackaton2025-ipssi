<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304110903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes_competence (employes_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_EF2690B7F971F91F (employes_id), INDEX IDX_EF2690B715761DAB (competence_id), PRIMARY KEY(employes_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employes_competence ADD CONSTRAINT FK_EF2690B7F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employes_competence ADD CONSTRAINT FK_EF2690B715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employes_competence DROP FOREIGN KEY FK_EF2690B7F971F91F');
        $this->addSql('ALTER TABLE employes_competence DROP FOREIGN KEY FK_EF2690B715761DAB');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE employes_competence');
    }
}
