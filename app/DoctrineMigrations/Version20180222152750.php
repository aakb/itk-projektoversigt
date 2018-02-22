<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180222152750 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX search_name ON harvest_client (name)');
        $this->addSql('CREATE INDEX search_name ON harvest_project (name)');
        $this->addSql('CREATE INDEX search_is_billable ON harvest_project (is_billable)');
        $this->addSql('CREATE INDEX search_is_fixed_fee ON harvest_project (is_fixed_fee)');
        $this->addSql('CREATE INDEX search_is_active ON harvest_project (is_active)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX search_name ON harvest_client');
        $this->addSql('DROP INDEX search_name ON harvest_project');
        $this->addSql('DROP INDEX search_is_billable ON harvest_project');
        $this->addSql('DROP INDEX search_is_fixed_fee ON harvest_project');
        $this->addSql('DROP INDEX search_is_active ON harvest_project');
    }
}
