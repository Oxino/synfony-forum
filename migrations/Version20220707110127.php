<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707110127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket CHANGE is_close close TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD banned TINYINT(1) NOT NULL, ADD close TINYINT(1) NOT NULL, DROP is_banned, DROP is_closed');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket CHANGE close is_close TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_banned TINYINT(1) NOT NULL, ADD is_closed TINYINT(1) NOT NULL, DROP banned, DROP close');
    }
}
