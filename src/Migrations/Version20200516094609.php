<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516094609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ride (id INT AUTO_INCREMENT NOT NULL, vtc_id INT NOT NULL, start_position_id INT NOT NULL, end_position_id INT NOT NULL, user_id INT NOT NULL, ride_comparison_id INT NOT NULL, price INT NOT NULL, time_before_departure INT NOT NULL, INDEX IDX_9B3D7CD0D0784DBF (vtc_id), INDEX IDX_9B3D7CD087F33EF2 (start_position_id), INDEX IDX_9B3D7CD0D78AC839 (end_position_id), INDEX IDX_9B3D7CD0A76ED395 (user_id), INDEX IDX_9B3D7CD0BF3AB4C5 (ride_comparison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ride_option (ride_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_4766335E302A8A70 (ride_id), INDEX IDX_4766335EA7C41D6F (option_id), PRIMARY KEY(ride_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ride_comparison (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vtc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, indemnification INT NOT NULL, price_per_kilometer INT NOT NULL, price_per_minute INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0D0784DBF FOREIGN KEY (vtc_id) REFERENCES vtc (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD087F33EF2 FOREIGN KEY (start_position_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0D78AC839 FOREIGN KEY (end_position_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0BF3AB4C5 FOREIGN KEY (ride_comparison_id) REFERENCES ride_comparison (id)');
        $this->addSql('ALTER TABLE ride_option ADD CONSTRAINT FK_4766335E302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_option ADD CONSTRAINT FK_4766335EA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD saving_price INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ride_option DROP FOREIGN KEY FK_4766335EA7C41D6F');
        $this->addSql('ALTER TABLE ride_option DROP FOREIGN KEY FK_4766335E302A8A70');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0BF3AB4C5');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0D0784DBF');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE ride');
        $this->addSql('DROP TABLE ride_option');
        $this->addSql('DROP TABLE ride_comparison');
        $this->addSql('DROP TABLE vtc');
        $this->addSql('ALTER TABLE user DROP saving_price');
    }
}
