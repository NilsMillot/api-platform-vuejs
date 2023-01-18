<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118113432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE movie_screening_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE movie_screening (id INT NOT NULL, creator_id INT DEFAULT NULL, session_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price DOUBLE PRECISION NOT NULL, disposition_room TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_24DD207B61220EA6 ON movie_screening (creator_id)');
        $this->addSql('COMMENT ON COLUMN movie_screening.disposition_room IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE movie_screening ADD CONSTRAINT FK_24DD207B61220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE movie_screening_id_seq CASCADE');
        $this->addSql('ALTER TABLE movie_screening DROP CONSTRAINT FK_24DD207B61220EA6');
        $this->addSql('DROP TABLE movie_screening');
    }
}
