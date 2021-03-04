<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302092435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consultation ADD attended_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A64A5CE02 FOREIGN KEY (attended_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_964685A64A5CE02 ON consultation (attended_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A64A5CE02');
        $this->addSql('DROP INDEX IDX_964685A64A5CE02 ON consultation');
        $this->addSql('ALTER TABLE consultation DROP attended_by_id');
    }
}
