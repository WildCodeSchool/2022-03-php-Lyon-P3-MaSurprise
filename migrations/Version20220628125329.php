<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628125329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP street_number, DROP bis_ter_info, DROP street_name, DROP postcode, DROP city, DROP department, DROP extra_info, DROP order_validated');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD street_number INT DEFAULT NULL, ADD bis_ter_info VARCHAR(15) DEFAULT NULL, ADD street_name VARCHAR(255) NOT NULL, ADD postcode INT NOT NULL, ADD city VARCHAR(100) NOT NULL, ADD department VARCHAR(3) NOT NULL, ADD extra_info LONGTEXT DEFAULT NULL, ADD order_validated TINYINT(1) NOT NULL');
    }
}
