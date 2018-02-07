<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180203162318 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AD16FD959');
        $this->addSql('DROP INDEX UNIQ_A000672AD16FD959 ON replies');
        $this->addSql('ALTER TABLE replies DROP praise_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE replies ADD praise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AD16FD959 FOREIGN KEY (praise_id) REFERENCES praises (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A000672AD16FD959 ON replies (praise_id)');
    }
}
