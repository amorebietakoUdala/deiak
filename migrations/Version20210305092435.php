<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305092435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("insert into topic values (1,'Economía','Ekonomia')");
        $this->addSql("insert into topic values (2,'Padrón altas / modificaciones / certificados','Errolda altak /aldaketak / agiriak')");
        $this->addSql("insert into topic values (3,'Acción social / Educación','Gizarte ekintza / Hezkuntza')");
        $this->addSql("insert into topic values (4,'Servicios','Zerbitzuak')");
        $this->addSql("insert into topic values (5,'Cultura / Deporte','Kultura / Kirola')");
        $this->addSql("insert into topic values (6,'Urbanismo','Hirigintza')");
        $this->addSql("insert into topic values (7,'Promocíon económica y de empleo','Lan / Ekonomi sustapena')");
        $this->addSql("insert into topic values (8,'Secretaría','Idazkaritza')");
        $this->addSql("insert into topic values (9,'Alcaldía','Alkatetza')");
        $this->addSql("insert into topic values (10,'Policía municipal','Udaltzaingoa')");
        $this->addSql("insert into topic values (11,'Euskera / Euskaltegi','Euskara / Euskaltegia')");
        $this->addSql("insert into topic values (12,'Otros','Beste batzuk')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM topic where id=1');
        $this->addSql('DELETE FROM topic where id=2');
        $this->addSql('DELETE FROM topic where id=3');
        $this->addSql('DELETE FROM topic where id=4');
        $this->addSql('DELETE FROM topic where id=5');
        $this->addSql('DELETE FROM topic where id=6');
        $this->addSql('DELETE FROM topic where id=7');
        $this->addSql('DELETE FROM topic where id=8');
        $this->addSql('DELETE FROM topic where id=9');
        $this->addSql('DELETE FROM topic where id=10');
        $this->addSql('DELETE FROM topic where id=11');
        $this->addSql('DELETE FROM topic where id=12');
    }
}
