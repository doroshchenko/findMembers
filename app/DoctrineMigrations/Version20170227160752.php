<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170227160752 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_conversation_relations DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_conversation_relations ADD PRIMARY KEY (user_conversation_id, user_id)');
        $this->addSql('ALTER TABLE fos_user ADD image VARCHAR(255) default NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user DROP image');
        $this->addSql('ALTER TABLE user_conversation_relations DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_conversation_relations ADD PRIMARY KEY (user_id, user_conversation_id)');
    }
}
