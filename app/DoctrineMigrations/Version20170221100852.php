<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170221100852 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */

    private $eventTags = [
        ['name' => 'путешествия'],
        ['name' => 'спортивные'],
        ['name' => 'волонтерство'],
        ['name' => 'развлечения'],
        ['name' => 'пойти вечером'],
        ['name' => 'нужна помощь'],
        ['name' => 'минифутбол']
    ];
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        foreach ($this->eventTags as $tag) {
            $this->addSql('INSERT into tag (id, name) values(null,:name)', $tag);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        foreach ($this->eventTags as $tag) {
            $this->addSql('DELETE from tag  where name = :name', $tag);
        }
    }
}
