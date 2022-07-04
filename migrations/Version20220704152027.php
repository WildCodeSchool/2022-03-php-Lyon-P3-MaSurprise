<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704152027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, billing_address_id INT NOT NULL, ordered_at DATETIME NOT NULL, order_status VARCHAR(50) NOT NULL, collect_date DATETIME DEFAULT NULL, total DOUBLE PRECISION NOT NULL, number VARCHAR(255) NOT NULL, INDEX IDX_F52993986C755722 (buyer_id), INDEX IDX_F529939879D0C0E4 (billing_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, order_reference_id INT NOT NULL, seller_id INT NOT NULL, delivery_address_id INT NOT NULL, cake_name VARCHAR(255) NOT NULL, cake_price DOUBLE PRECISION NOT NULL, cake_size VARCHAR(255) NOT NULL, quantity INT NOT NULL, INDEX IDX_9CE58EE112854AC3 (order_reference_id), INDEX IDX_9CE58EE18DE820D9 (seller_id), INDEX IDX_9CE58EE1EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939879D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE112854AC3 FOREIGN KEY (order_reference_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE address DROP INDEX UNIQ_D4E6F8179D0C0E4, ADD INDEX IDX_D4E6F8179D0C0E4 (billing_address_id)');
        $this->addSql('ALTER TABLE address ADD status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE112854AC3');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('ALTER TABLE address DROP INDEX IDX_D4E6F8179D0C0E4, ADD UNIQUE INDEX UNIQ_D4E6F8179D0C0E4 (billing_address_id)');
        $this->addSql('ALTER TABLE address DROP status');
    }
}
