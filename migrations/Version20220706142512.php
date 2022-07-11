<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706142512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cake ADD category VARCHAR(255) NOT NULL, DROP picture2, DROP picture3, DROP picture4, DROP picture5');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cake ADD picture2 VARCHAR(255) DEFAULT NULL, ADD picture3 VARCHAR(255) DEFAULT NULL, ADD picture4 VARCHAR(255) DEFAULT NULL, ADD picture5 VARCHAR(255) DEFAULT NULL, DROP category');
    }
}
