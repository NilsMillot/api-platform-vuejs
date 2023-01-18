<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118112304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quizz_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, genre TEXT NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, backdrop_path VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, video BOOLEAN NOT NULL, vote_average INT NOT NULL, vote_count INT NOT NULL, runtime INT DEFAULT NULL, release_date VARCHAR(255) NOT NULL, popularity INT NOT NULL, original_language VARCHAR(255) NOT NULL, original_title VARCHAR(255) NOT NULL, overwiew VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN movie.genre IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE quizz (id INT NOT NULL, questions TEXT NOT NULL, answers TEXT NOT NULL, number_of_credits_to_be_earned INT NOT NULL, deadline DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quizz.questions IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN quizz.answers IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quizz_id_seq CASCADE');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE quizz');
    }
}
