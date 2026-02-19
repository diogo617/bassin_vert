<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260215232230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop orphan table program';
    }

    public function up(Schema $schema): void
    {
        // Drop foreign keys first
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784A76ED395');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784F229C21E');
        // Drop the table
        $this->addSql('DROP TABLE program');
    }

    public function down(Schema $schema): void
    {
        // Table was dropped and schema is unknown, so it cannot be exactly recreated.
        // If you need to revert, you would need to recreate this table manually based on your backups or knowledge.
    }
}
