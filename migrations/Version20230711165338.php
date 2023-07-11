<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230711165338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__jokes AS SELECT id, category_id, title, description, created_at, updated_at FROM jokes');
        $this->addSql('DROP TABLE jokes');
        $this->addSql('CREATE TABLE jokes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_E3E1E40112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E3E1E401A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jokes (id, category_id, title, description, created_at, updated_at) SELECT id, category_id, title, description, created_at, updated_at FROM __temp__jokes');
        $this->addSql('DROP TABLE __temp__jokes');
        $this->addSql('CREATE INDEX IDX_E3E1E40112469DE2 ON jokes (category_id)');
        $this->addSql('CREATE INDEX IDX_E3E1E401A76ED395 ON jokes (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__jokes AS SELECT id, category_id, title, description, created_at, updated_at FROM jokes');
        $this->addSql('DROP TABLE jokes');
        $this->addSql('CREATE TABLE jokes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_E3E1E40112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jokes (id, category_id, title, description, created_at, updated_at) SELECT id, category_id, title, description, created_at, updated_at FROM __temp__jokes');
        $this->addSql('DROP TABLE __temp__jokes');
        $this->addSql('CREATE INDEX IDX_E3E1E40112469DE2 ON jokes (category_id)');
    }
}
