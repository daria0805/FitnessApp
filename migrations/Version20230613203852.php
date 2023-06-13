<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613203852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_food ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_food ADD CONSTRAINT FK_AEB9653EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AEB9653EA76ED395 ON user_food (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_food DROP FOREIGN KEY FK_AEB9653EA76ED395');
        $this->addSql('DROP INDEX IDX_AEB9653EA76ED395 ON user_food');
        $this->addSql('ALTER TABLE user_food DROP user_id');
    }
}
