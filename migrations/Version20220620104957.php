<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620104957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker DROP lastname, DROP firstname, DROP email, DROP password, DROP phone, CHANGE address delivery_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD baker_id INT DEFAULT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B1FA4C6F FOREIGN KEY (baker_id) REFERENCES baker (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B1FA4C6F ON user (baker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, CHANGE delivery_address address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B1FA4C6F');
        $this->addSql('DROP INDEX UNIQ_8D93D649B1FA4C6F ON user');
        $this->addSql('ALTER TABLE user DROP baker_id, DROP lastname, DROP firstname, DROP address, DROP phone');
    }
}
