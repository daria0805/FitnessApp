<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531210854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diet_plan_database ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE diet_plan_database ADD CONSTRAINT FK_EFCEE42BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFCEE42BA76ED395 ON diet_plan_database (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diet_plan_database DROP FOREIGN KEY FK_EFCEE42BA76ED395');
        $this->addSql('DROP INDEX UNIQ_EFCEE42BA76ED395 ON diet_plan_database');
        $this->addSql('ALTER TABLE diet_plan_database DROP user_id');
    }
}
