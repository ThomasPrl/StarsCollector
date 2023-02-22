<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111180730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE star_type (star_id INTEGER NOT NULL, type_id INTEGER NOT NULL, PRIMARY KEY(star_id, type_id), CONSTRAINT FK_7BCF4F602C3B70D7 FOREIGN KEY (star_id) REFERENCES star (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7BCF4F60C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7BCF4F602C3B70D7 ON star_type (star_id)');
        $this->addSql('CREATE INDEX IDX_7BCF4F60C54C8C93 ON star_type (type_id)');
        $this->addSql('CREATE TABLE type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_8CDE5729727ACA70 FOREIGN KEY (parent_id) REFERENCES type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8CDE5729727ACA70 ON type (parent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__star AS SELECT id, space_id, description, mass, temperature, diameter FROM star');
        $this->addSql('DROP TABLE star');
        $this->addSql('CREATE TABLE star (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, space_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, mass INTEGER NOT NULL, temperature INTEGER NOT NULL, diameter INTEGER NOT NULL, CONSTRAINT FK_C9DB5A1423575340 FOREIGN KEY (space_id) REFERENCES space (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO star (id, space_id, description, mass, temperature, diameter) SELECT id, space_id, description, mass, temperature, diameter FROM __temp__star');
        $this->addSql('DROP TABLE __temp__star');
        $this->addSql('CREATE INDEX IDX_C9DB5A1423575340 ON star (space_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE star_type');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE star ADD COLUMN type VARCHAR(255) NOT NULL');
    }
}
