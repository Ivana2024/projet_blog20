<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624092448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD last_name VARCHAR(180) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD is_verified TINYINT(1) NOT NULL, DROP firstName, DROP lastName, DROP createdAt, DROP verifiedAt, DROP updateAt');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD lastName VARCHAR(255) NOT NULL, ADD createdAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD verifiedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updateAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP last_name, DROP created_at, DROP verified_at, DROP update_at, DROP is_verified, CHANGE first_name firstName VARCHAR(255) NOT NULL');
    }
}
