<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219104201 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE harvest_client (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_invoice (id INT NOT NULL, client_key VARCHAR(255) DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, purchase_order VARCHAR(255) DEFAULT NULL, amount NUMERIC(10, 2) DEFAULT NULL, due_amount NUMERIC(10, 2) DEFAULT NULL, tax NUMERIC(10, 2) DEFAULT NULL, tax_amount NUMERIC(10, 2) DEFAULT NULL, tax2 NUMERIC(10, 2) DEFAULT NULL, tax2_amount NUMERIC(10, 2) DEFAULT NULL, discount NUMERIC(10, 2) DEFAULT NULL, discount_amount NUMERIC(10, 2) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, period_start DATE DEFAULT NULL, period_end DATE DEFAULT NULL, issue_date DATE DEFAULT NULL, due_date DATE DEFAULT NULL, sent_at DATETIME DEFAULT NULL, paid_at DATETIME DEFAULT NULL, paid_date DATE DEFAULT NULL, closed_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_project (id INT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, is_billable TINYINT(1) DEFAULT NULL, is_fixed_fee TINYINT(1) DEFAULT NULL, bill_by VARCHAR(255) DEFAULT NULL, hourly_rate NUMERIC(10, 2) DEFAULT NULL, budget NUMERIC(10, 2) DEFAULT NULL, budget_by VARCHAR(255) DEFAULT NULL, notify_when_over_budget TINYINT(1) DEFAULT NULL, over_budget_notification_percentage NUMERIC(10, 2) NOT NULL, over_budget_notification_date DATE DEFAULT NULL, show_budget_to_all TINYINT(1) DEFAULT NULL, cost_budget NUMERIC(10, 2) DEFAULT NULL, cost_budget_include_expenses TINYINT(1) DEFAULT NULL, fee NUMERIC(10, 2) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, starts_on DATE DEFAULT NULL, ends_on DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, INDEX IDX_F50271C519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_project_assignment (id INT NOT NULL, client_id INT DEFAULT NULL, project_id INT DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, is_project_manager TINYINT(1) DEFAULT NULL, hourly_rate NUMERIC(10, 2) DEFAULT NULL, budget NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, INDEX IDX_386E8FE19EB6921 (client_id), INDEX IDX_386E8FE166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_task (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, billable_by_default TINYINT(1) DEFAULT NULL, default_hourly_rate NUMERIC(10, 2) DEFAULT NULL, is_default TINYINT(1) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_task_assignment (id INT NOT NULL, task_id INT DEFAULT NULL, project_assignment_id INT DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, billable TINYINT(1) DEFAULT NULL, hourly_rate NUMERIC(10, 2) DEFAULT NULL, budget NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, INDEX IDX_7BC50EE78DB60186 (task_id), INDEX IDX_7BC50EE750295FE (project_assignment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_time_entry (id INT NOT NULL, user_id INT DEFAULT NULL, user_assignment_id INT DEFAULT NULL, client_id INT DEFAULT NULL, project_id INT DEFAULT NULL, task_id INT DEFAULT NULL, task_assignment_id INT DEFAULT NULL, invoice_id INT DEFAULT NULL, spent_date DATE DEFAULT NULL, hours NUMERIC(10, 2) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, is_locked TINYINT(1) DEFAULT NULL, locked_reason VARCHAR(255) DEFAULT NULL, is_closed TINYINT(1) DEFAULT NULL, is_billed TINYINT(1) DEFAULT NULL, timer_started_at DATETIME DEFAULT NULL, started_time TIME DEFAULT NULL, ended_time TIME DEFAULT NULL, is_running TINYINT(1) DEFAULT NULL, billable TINYINT(1) DEFAULT NULL, budgeted TINYINT(1) DEFAULT NULL, billable_rate NUMERIC(10, 2) DEFAULT NULL, cost_rate NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, INDEX IDX_5131DB65A76ED395 (user_id), INDEX IDX_5131DB653F1DAFA8 (user_assignment_id), INDEX IDX_5131DB6519EB6921 (client_id), INDEX IDX_5131DB65166D1F9C (project_id), INDEX IDX_5131DB658DB60186 (task_id), INDEX IDX_5131DB659484CFA9 (task_assignment_id), INDEX IDX_5131DB652989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_user (id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, has_access_to_all_future_projects TINYINT(1) DEFAULT NULL, is_contractor TINYINT(1) DEFAULT NULL, is_admin TINYINT(1) DEFAULT NULL, is_project_manager TINYINT(1) DEFAULT NULL, can_see_rates TINYINT(1) DEFAULT NULL, can_create_projects TINYINT(1) DEFAULT NULL, can_create_invoices TINYINT(1) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, weekly_capacity INT DEFAULT NULL, default_hourly_rate NUMERIC(10, 2) DEFAULT NULL, cost_rate NUMERIC(10, 2) DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', avatar_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest_user_assignment (id INT NOT NULL, user_id INT DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, is_project_manager TINYINT(1) DEFAULT NULL, hourly_rate NUMERIC(10, 2) DEFAULT NULL, budget NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, seen_on_last_sync TINYINT(1) NOT NULL, owned_by VARCHAR(255) DEFAULT NULL, INDEX IDX_C0B183A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE harvest_project ADD CONSTRAINT FK_F50271C519EB6921 FOREIGN KEY (client_id) REFERENCES harvest_client (id)');
        $this->addSql('ALTER TABLE harvest_project_assignment ADD CONSTRAINT FK_386E8FE19EB6921 FOREIGN KEY (client_id) REFERENCES harvest_client (id)');
        $this->addSql('ALTER TABLE harvest_project_assignment ADD CONSTRAINT FK_386E8FE166D1F9C FOREIGN KEY (project_id) REFERENCES harvest_project (id)');
        $this->addSql('ALTER TABLE harvest_task_assignment ADD CONSTRAINT FK_7BC50EE78DB60186 FOREIGN KEY (task_id) REFERENCES harvest_task (id)');
        $this->addSql('ALTER TABLE harvest_task_assignment ADD CONSTRAINT FK_7BC50EE750295FE FOREIGN KEY (project_assignment_id) REFERENCES harvest_project_assignment (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB65A76ED395 FOREIGN KEY (user_id) REFERENCES harvest_user (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB653F1DAFA8 FOREIGN KEY (user_assignment_id) REFERENCES harvest_user_assignment (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB6519EB6921 FOREIGN KEY (client_id) REFERENCES harvest_client (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB65166D1F9C FOREIGN KEY (project_id) REFERENCES harvest_project (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB658DB60186 FOREIGN KEY (task_id) REFERENCES harvest_task (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB659484CFA9 FOREIGN KEY (task_assignment_id) REFERENCES harvest_task_assignment (id)');
        $this->addSql('ALTER TABLE harvest_time_entry ADD CONSTRAINT FK_5131DB652989F1FD FOREIGN KEY (invoice_id) REFERENCES harvest_invoice (id)');
        $this->addSql('ALTER TABLE harvest_user_assignment ADD CONSTRAINT FK_C0B183A4A76ED395 FOREIGN KEY (user_id) REFERENCES harvest_user (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE harvest_project DROP FOREIGN KEY FK_F50271C519EB6921');
        $this->addSql('ALTER TABLE harvest_project_assignment DROP FOREIGN KEY FK_386E8FE19EB6921');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB6519EB6921');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB652989F1FD');
        $this->addSql('ALTER TABLE harvest_project_assignment DROP FOREIGN KEY FK_386E8FE166D1F9C');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB65166D1F9C');
        $this->addSql('ALTER TABLE harvest_task_assignment DROP FOREIGN KEY FK_7BC50EE750295FE');
        $this->addSql('ALTER TABLE harvest_task_assignment DROP FOREIGN KEY FK_7BC50EE78DB60186');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB658DB60186');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB659484CFA9');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB65A76ED395');
        $this->addSql('ALTER TABLE harvest_user_assignment DROP FOREIGN KEY FK_C0B183A4A76ED395');
        $this->addSql('ALTER TABLE harvest_time_entry DROP FOREIGN KEY FK_5131DB653F1DAFA8');
        $this->addSql('DROP TABLE harvest_client');
        $this->addSql('DROP TABLE harvest_invoice');
        $this->addSql('DROP TABLE harvest_project');
        $this->addSql('DROP TABLE harvest_project_assignment');
        $this->addSql('DROP TABLE harvest_task');
        $this->addSql('DROP TABLE harvest_task_assignment');
        $this->addSql('DROP TABLE harvest_time_entry');
        $this->addSql('DROP TABLE harvest_user');
        $this->addSql('DROP TABLE harvest_user_assignment');
    }
}
