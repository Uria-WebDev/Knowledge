<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260313153437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cursus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cursus_lesson (cursus_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_BF548FB840AEF4B9 (cursus_id), INDEX IDX_BF548FB8CDF80196 (lesson_id), PRIMARY KEY (cursus_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE theme_cursus (theme_id INT NOT NULL, cursus_id INT NOT NULL, INDEX IDX_D26D94BF59027487 (theme_id), INDEX IDX_D26D94BF40AEF4B9 (cursus_id), PRIMARY KEY (theme_id, cursus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT NOT NULL, email_verification_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE lesson_bought (user_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_773FC6B8A76ED395 (user_id), INDEX IDX_773FC6B8CDF80196 (lesson_id), PRIMARY KEY (user_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cursus_bought (user_id INT NOT NULL, cursus_id INT NOT NULL, INDEX IDX_4389CDA4A76ED395 (user_id), INDEX IDX_4389CDA440AEF4B9 (cursus_id), PRIMARY KEY (user_id, cursus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cursus_lesson ADD CONSTRAINT FK_BF548FB840AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cursus_lesson ADD CONSTRAINT FK_BF548FB8CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_cursus ADD CONSTRAINT FK_D26D94BF59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_cursus ADD CONSTRAINT FK_D26D94BF40AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_bought ADD CONSTRAINT FK_773FC6B8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_bought ADD CONSTRAINT FK_773FC6B8CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cursus_bought ADD CONSTRAINT FK_4389CDA4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cursus_bought ADD CONSTRAINT FK_4389CDA440AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cursus_lesson DROP FOREIGN KEY FK_BF548FB840AEF4B9');
        $this->addSql('ALTER TABLE cursus_lesson DROP FOREIGN KEY FK_BF548FB8CDF80196');
        $this->addSql('ALTER TABLE theme_cursus DROP FOREIGN KEY FK_D26D94BF59027487');
        $this->addSql('ALTER TABLE theme_cursus DROP FOREIGN KEY FK_D26D94BF40AEF4B9');
        $this->addSql('ALTER TABLE lesson_bought DROP FOREIGN KEY FK_773FC6B8A76ED395');
        $this->addSql('ALTER TABLE lesson_bought DROP FOREIGN KEY FK_773FC6B8CDF80196');
        $this->addSql('ALTER TABLE cursus_bought DROP FOREIGN KEY FK_4389CDA4A76ED395');
        $this->addSql('ALTER TABLE cursus_bought DROP FOREIGN KEY FK_4389CDA440AEF4B9');
        $this->addSql('DROP TABLE cursus');
        $this->addSql('DROP TABLE cursus_lesson');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_cursus');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE lesson_bought');
        $this->addSql('DROP TABLE cursus_bought');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
