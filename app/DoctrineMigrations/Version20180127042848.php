<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180127042848 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE harvest_client ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_invoice ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_project ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_project_assignment ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_task ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_task_assignment ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_time_entry ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_user ADD seen_on_last_sync TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE harvest_user_assignment ADD seen_on_last_sync TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE harvest_client DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_invoice DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_project DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_project_assignment DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_task DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_task_assignment DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_time_entry DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_user DROP seen_on_last_sync');
        $this->addSql('ALTER TABLE harvest_user_assignment DROP seen_on_last_sync');
    }
}
