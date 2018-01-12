<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180110171021 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE channels (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, channel_slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE threads ADD channel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDD72F5A1AA FOREIGN KEY (channel_id) REFERENCES channels (id)');
        $this->addSql('CREATE INDEX IDX_6F8E3DDD72F5A1AA ON threads (channel_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDD72F5A1AA');
        $this->addSql('DROP TABLE channels');
        $this->addSql('DROP INDEX IDX_6F8E3DDD72F5A1AA ON threads');
        $this->addSql('ALTER TABLE threads DROP channel_id');
    }
}
