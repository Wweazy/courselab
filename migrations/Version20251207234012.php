<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251207234012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Empty migration to sync metadata';
    }

    public function up(Schema $schema): void
    {
        // no-op
    }

    public function down(Schema $schema): void
    {
        // no-op
    }
}
