<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621135455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, ordered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', cake_name VARCHAR(255) NOT NULL, cake_size VARCHAR(255) NOT NULL, street_number INT DEFAULT NULL, bis_ter_info VARCHAR(15) DEFAULT NULL, street_name VARCHAR(255) NOT NULL, postcode INT NOT NULL, city VARCHAR(100) NOT NULL, department VARCHAR(3) NOT NULL, extra_info LONGTEXT DEFAULT NULL, cake_price DOUBLE PRECISION NOT NULL, collect_date DATETIME DEFAULT NULL, order_validated TINYINT(1) NOT NULL, order_finished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `order`');
    }
}
