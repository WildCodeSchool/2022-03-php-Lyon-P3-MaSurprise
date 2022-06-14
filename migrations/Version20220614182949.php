<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614182949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE baker (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, commercial_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cake (id INT AUTO_INCREMENT NOT NULL, baker_id INT NOT NULL, created DATETIME NOT NULL, name VARCHAR(255) NOT NULL, picture1 VARCHAR(255) NOT NULL, picture2 VARCHAR(255) DEFAULT NULL, picture3 VARCHAR(255) DEFAULT NULL, picture4 VARCHAR(255) DEFAULT NULL, picture5 VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, allergens LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, size VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FA13015DB1FA4C6F (baker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cake ADD CONSTRAINT FK_FA13015DB1FA4C6F FOREIGN KEY (baker_id) REFERENCES baker (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cake DROP FOREIGN KEY FK_FA13015DB1FA4C6F');
        $this->addSql('DROP TABLE baker');
        $this->addSql('DROP TABLE cake');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
