<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260215231752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop orphan tables progam and contact_request';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS progam');
        $this->addSql('DROP TABLE IF EXISTS contact_request');
    }

    public function down(Schema $schema): void
    {
        // Tables were dropped and schemas are unknown, so they cannot be recreated exactly.
        // If you need to revert, you would need to recreate these tables manually based on your backups or knowledge.
    }
}
