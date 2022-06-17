<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617085749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE baker ADD baker_type VARCHAR(255) NOT NULL, ADD siret VARCHAR(255) DEFAULT NULL, ADD diploma VARCHAR(255) DEFAULT NULL, ADD logo VARCHAR(255) DEFAULT NULL, ADD facebook VARCHAR(255) DEFAULT NULL, ADD instagram VARCHAR(255) DEFAULT NULL, ADD update_at DATETIME DEFAULT NULL, CHANGE address services VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cake ADD update_at DATETIME DEFAULT NULL, CHANGE picture1 picture1 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE baker ADD address VARCHAR(255) DEFAULT NULL, DROP baker_type, DROP services, DROP siret, DROP diploma, DROP logo, DROP facebook, DROP instagram, DROP update_at');
        $this->addSql('ALTER TABLE cake DROP update_at, CHANGE picture1 picture1 VARCHAR(255) NOT NULL');
    }
}
