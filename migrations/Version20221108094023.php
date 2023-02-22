<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108094023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sky (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_id INTEGER NOT NULL, description VARCHAR(255) NOT NULL, publish BOOLEAN NOT NULL, CONSTRAINT FK_62674EF6A99F74A FOREIGN KEY (membre_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_62674EF6A99F74A ON sky (membre_id)');
        $this->addSql('CREATE TABLE sky_star (sky_id INTEGER NOT NULL, star_id INTEGER NOT NULL, PRIMARY KEY(sky_id, star_id), CONSTRAINT FK_B0BDD01E5DA16BA4 FOREIGN KEY (sky_id) REFERENCES sky (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B0BDD01E2C3B70D7 FOREIGN KEY (star_id) REFERENCES star (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B0BDD01E5DA16BA4 ON sky_star (sky_id)');
        $this->addSql('CREATE INDEX IDX_B0BDD01E2C3B70D7 ON sky_star (star_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sky');
        $this->addSql('DROP TABLE sky_star');
    }
}
