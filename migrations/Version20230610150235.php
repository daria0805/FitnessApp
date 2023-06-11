<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610150235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_food (id INT AUTO_INCREMENT NOT NULL, meal_id INT NOT NULL, food_name VARCHAR(255) NOT NULL, calories INT NOT NULL, grams NUMERIC(8, 2) NOT NULL, carbs NUMERIC(8, 2) NOT NULL, fat NUMERIC(8, 2) NOT NULL, protein NUMERIC(8, 2) NOT NULL, INDEX IDX_AEB9653E639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_food ADD CONSTRAINT FK_AEB9653E639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_food DROP FOREIGN KEY FK_AEB9653E639666D6');
        $this->addSql('DROP TABLE user_food');
    }
}
