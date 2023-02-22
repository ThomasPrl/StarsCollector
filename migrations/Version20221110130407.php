<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110130407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sky AS SELECT id, membre_id, description, publish FROM sky');
        $this->addSql('DROP TABLE sky');
        $this->addSql('CREATE TABLE sky (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, createur_id INTEGER NOT NULL, description VARCHAR(255) NOT NULL, publish BOOLEAN NOT NULL, CONSTRAINT FK_62674EF73A201E5 FOREIGN KEY (createur_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO sky (id, createur_id, description, publish) SELECT id, membre_id, description, publish FROM __temp__sky');
        $this->addSql('DROP TABLE __temp__sky');
        $this->addSql('CREATE INDEX IDX_62674EF73A201E5 ON sky (createur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sky AS SELECT id, createur_id, description, publish FROM sky');
        $this->addSql('DROP TABLE sky');
        $this->addSql('CREATE TABLE sky (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_id INTEGER NOT NULL, description VARCHAR(255) NOT NULL, publish BOOLEAN NOT NULL, CONSTRAINT FK_62674EF6A99F74A FOREIGN KEY (membre_id) REFERENCES member (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO sky (id, membre_id, description, publish) SELECT id, createur_id, description, publish FROM __temp__sky');
        $this->addSql('DROP TABLE __temp__sky');
        $this->addSql('CREATE INDEX IDX_62674EF6A99F74A ON sky (membre_id)');
    }
}
