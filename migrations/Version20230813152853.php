<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813152853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name_category VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, to_know_id INT DEFAULT NULL, date_of_movement DATE NOT NULL, quantity_movement INT NOT NULL, INDEX IDX_F4DD95F7C54C8C93 (type_id), INDEX IDX_F4DD95F7DC31F025 (to_know_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nature (id INT AUTO_INCREMENT NOT NULL, to_belong_id INT DEFAULT NULL, name_nature VARCHAR(20) NOT NULL, INDEX IDX_B1D882A791734588 (to_belong_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, name_position VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, to_possess_id INT DEFAULT NULL, name_product VARCHAR(20) NOT NULL, price_product DOUBLE PRECISION NOT NULL, vat_produt DOUBLE PRECISION DEFAULT NULL, code_product VARCHAR(6) DEFAULT NULL, quantity_product INT NOT NULL, quantity_alert INT DEFAULT NULL, INDEX IDX_D34A04AD48B40A85 (to_possess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name_status VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name_type VARCHAR(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, to_have_id INT DEFAULT NULL, to_occupy_id INT DEFAULT NULL, first_name_user VARCHAR(30) NOT NULL, last_name_user VARCHAR(30) NOT NULL, date_of_birth_user DATE DEFAULT NULL, mail_user VARCHAR(30) NOT NULL, password_user VARCHAR(100) NOT NULL, INDEX IDX_8D93D6498B6F328A (to_have_id), INDEX IDX_8D93D6499D40F303 (to_occupy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_product (user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8B471AA7A76ED395 (user_id), INDEX IDX_8B471AA74584665A (product_id), PRIMARY KEY(user_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7DC31F025 FOREIGN KEY (to_know_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE nature ADD CONSTRAINT FK_B1D882A791734588 FOREIGN KEY (to_belong_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD48B40A85 FOREIGN KEY (to_possess_id) REFERENCES nature (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498B6F328A FOREIGN KEY (to_have_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D40F303 FOREIGN KEY (to_occupy_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nature DROP FOREIGN KEY FK_B1D882A791734588');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD48B40A85');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D40F303');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7DC31F025');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA74584665A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498B6F328A');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7C54C8C93');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA7A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE nature');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_product');
    }
}
