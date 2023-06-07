<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606213216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal CHANGE grams grams NUMERIC(8, 2) NOT NULL, CHANGE carbs carbs NUMERIC(8, 2) NOT NULL, CHANGE fat fat NUMERIC(8, 2) NOT NULL, CHANGE protein protein NUMERIC(8, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal CHANGE grams grams DOUBLE PRECISION UNSIGNED NOT NULL, CHANGE carbs carbs DOUBLE PRECISION UNSIGNED NOT NULL, CHANGE fat fat DOUBLE PRECISION UNSIGNED NOT NULL, CHANGE protein protein DOUBLE PRECISION UNSIGNED NOT NULL');
    }
}
