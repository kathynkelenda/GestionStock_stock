<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903040714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE password_update ADD to_update_id INT DEFAULT NULL, ADD old_password VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE password_update ADD CONSTRAINT FK_15CCA440E4353DC0 FOREIGN KEY (to_update_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_15CCA440E4353DC0 ON password_update (to_update_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE password_update DROP FOREIGN KEY FK_15CCA440E4353DC0');
        $this->addSql('DROP INDEX UNIQ_15CCA440E4353DC0 ON password_update');
        $this->addSql('ALTER TABLE password_update DROP to_update_id, DROP old_password');
    }
}
