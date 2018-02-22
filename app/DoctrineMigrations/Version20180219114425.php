<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219114425 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX search_owned_by ON harvest_client (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_invoice (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_project (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_project_assignment (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_task (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_task_assignment (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_time_entry (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_user (owned_by)');
        $this->addSql('CREATE INDEX search_owned_by ON harvest_user_assignment (owned_by)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX search_owned_by ON harvest_client');
        $this->addSql('DROP INDEX search_owned_by ON harvest_invoice');
        $this->addSql('DROP INDEX search_owned_by ON harvest_project');
        $this->addSql('DROP INDEX search_owned_by ON harvest_project_assignment');
        $this->addSql('DROP INDEX search_owned_by ON harvest_task');
        $this->addSql('DROP INDEX search_owned_by ON harvest_task_assignment');
        $this->addSql('DROP INDEX search_owned_by ON harvest_time_entry');
        $this->addSql('DROP INDEX search_owned_by ON harvest_user');
        $this->addSql('DROP INDEX search_owned_by ON harvest_user_assignment');
    }
}
