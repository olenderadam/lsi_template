<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220716085619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history_log ADD export_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE history_log ADD location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE history_log RENAME COLUMN name TO export_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE history_log ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE history_log DROP export_name');
        $this->addSql('ALTER TABLE history_log DROP export_date');
        $this->addSql('ALTER TABLE history_log DROP location');
    }
}
