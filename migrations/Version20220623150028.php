<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623150028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EBF23851');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EBF23851');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES baker (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
