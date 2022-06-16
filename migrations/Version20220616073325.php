<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616073325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker DROP FOREIGN KEY FK_4449E865F98AF5B6');
        $this->addSql('DROP INDEX IDX_4449E865F98AF5B6 ON baker');
        $this->addSql('ALTER TABLE baker ADD bis_ter_info VARCHAR(15) DEFAULT NULL, ADD extra_info VARCHAR(100) DEFAULT NULL, DROP other_address_department_id, DROP street_number_additional, DROP additional_information, DROP other_address_street_number, DROP other_address_street_number_additional, DROP other_address_street_name, DROP other_address_postcode, DROP other_address_additional_information');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baker ADD other_address_department_id INT DEFAULT NULL, ADD other_address_street_number INT DEFAULT NULL, ADD other_address_street_number_additional VARCHAR(15) DEFAULT NULL, ADD other_address_street_name VARCHAR(100) DEFAULT NULL, ADD other_address_postcode INT DEFAULT NULL, ADD other_address_additional_information VARCHAR(100) DEFAULT NULL, CHANGE bis_ter_info street_number_additional VARCHAR(15) DEFAULT NULL, CHANGE extra_info additional_information VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE baker ADD CONSTRAINT FK_4449E865F98AF5B6 FOREIGN KEY (other_address_department_id) REFERENCES department (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4449E865F98AF5B6 ON baker (other_address_department_id)');
    }
}
