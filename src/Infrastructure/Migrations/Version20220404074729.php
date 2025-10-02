<?php

declare(strict_types=1);

namespace RichId\MailerBundle\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220404074729 extends AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE module_email_footer (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, default_value VARCHAR(600) NOT NULL, value VARCHAR(600) DEFAULT NULL, date_update DATETIME NOT NULL, UNIQUE INDEX UNIQ_F7F84E51989D9B62 (slug), UNIQUE INDEX UNIQ_F7F84E515E237E06 (name), UNIQUE INDEX UNIQ_F7F84E51462CE4F5 (position), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE module_email_footer');
    }
}
