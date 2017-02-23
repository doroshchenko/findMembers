<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223105824 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_conversation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, author_id INT DEFAULT NULL, text LONGTEXT NOT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_EEB02E759AC0396 (conversation_id), INDEX IDX_EEB02E75F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_conversation_relations (user_id INT NOT NULL, user_conversation_id INT NOT NULL, INDEX IDX_BE46B9D5A76ED395 (user_id), INDEX IDX_BE46B9D51B706F19 (user_conversation_id), PRIMARY KEY(user_id, user_conversation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_message ADD CONSTRAINT FK_EEB02E759AC0396 FOREIGN KEY (conversation_id) REFERENCES user_conversation (id)');
        $this->addSql('ALTER TABLE user_message ADD CONSTRAINT FK_EEB02E75F675F31B FOREIGN KEY (author_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE user_conversation_relations ADD CONSTRAINT FK_BE46B9D5A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_conversation_relations ADD CONSTRAINT FK_BE46B9D51B706F19 FOREIGN KEY (user_conversation_id) REFERENCES user_conversation (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_message DROP FOREIGN KEY FK_EEB02E759AC0396');
        $this->addSql('ALTER TABLE user_conversation_relations DROP FOREIGN KEY FK_BE46B9D51B706F19');
        $this->addSql('DROP TABLE user_conversation');
        $this->addSql('DROP TABLE user_message');
        $this->addSql('DROP TABLE user_conversation_relations');
    }
}
