<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712075523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker ADD delivery_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE baker ADD CONSTRAINT FK_4449E865EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4449E865EBF23851 ON baker (delivery_address_id)');
        $this->addSql('ALTER TABLE user ADD delivery_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649EBF23851 ON user (delivery_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker DROP FOREIGN KEY FK_4449E865EBF23851');
        $this->addSql('DROP INDEX UNIQ_4449E865EBF23851 ON baker');
        $this->addSql('ALTER TABLE baker DROP delivery_address_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EBF23851');
        $this->addSql('DROP INDEX UNIQ_8D93D649EBF23851 ON user');
        $this->addSql('ALTER TABLE user DROP delivery_address_id');
    }
}
