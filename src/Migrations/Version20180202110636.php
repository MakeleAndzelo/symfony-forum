<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180202110636 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE praises ADD reply_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE praises ADD CONSTRAINT FK_52A32C868A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52A32C868A0E4E7F ON praises (reply_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE praises DROP FOREIGN KEY FK_52A32C868A0E4E7F');
        $this->addSql('DROP INDEX UNIQ_52A32C868A0E4E7F ON praises');
        $this->addSql('ALTER TABLE praises DROP reply_id');
    }
}
