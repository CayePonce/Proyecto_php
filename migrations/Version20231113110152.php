<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113110152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, adult TINYINT(1) DEFAULT NULL, backdrop_path VARCHAR(255) DEFAULT NULL, belongs_to_colection TINYINT(1) DEFAULT NULL, budget INT DEFAULT NULL, genres VARCHAR(255) DEFAULT NULL, homepage VARCHAR(255) DEFAULT NULL, movie_id INT NOT NULL, original_language VARCHAR(255) DEFAULT NULL, original_title VARCHAR(255) NOT NULL, overview VARCHAR(255) DEFAULT NULL, popularity INT DEFAULT NULL, poster_path VARCHAR(255) DEFAULT NULL, production_companies VARCHAR(255) DEFAULT NULL, production_countries VARCHAR(255) DEFAULT NULL, release_date VARCHAR(255) DEFAULT NULL, revenue INT DEFAULT NULL, runtime INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, tagline VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, video TINYINT(1) DEFAULT NULL, vote_average DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE movie');
    }
}
