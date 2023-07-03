<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703115206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE segment CHANGE source_text source_text LONGTEXT NOT NULL, CHANGE target_text target_text LONGTEXT NOT NULL, CHANGE source_language source_language VARCHAR(2) NOT NULL, CHANGE target_language target_language VARCHAR(2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE segment CHANGE source_text source_text TINYTEXT NOT NULL, CHANGE target_text target_text VARCHAR(255) DEFAULT NULL, CHANGE source_language source_language VARCHAR(255) NOT NULL, CHANGE target_language target_language VARCHAR(255) NOT NULL');
    }
}
