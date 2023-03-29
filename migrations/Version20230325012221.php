<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325012221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE water ADD genre_id INT NOT NULL, ADD inventor_id INT NOT NULL');
        $this->addSql('ALTER TABLE water ADD CONSTRAINT FK_FB3314DA4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE water ADD CONSTRAINT FK_FB3314DA9CECD5D4 FOREIGN KEY (inventor_id) REFERENCES inventor (id)');
        $this->addSql('CREATE INDEX IDX_FB3314DA4296D31F ON water (genre_id)');
        $this->addSql('CREATE INDEX IDX_FB3314DA9CECD5D4 ON water (inventor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE water DROP FOREIGN KEY FK_FB3314DA4296D31F');
        $this->addSql('ALTER TABLE water DROP FOREIGN KEY FK_FB3314DA9CECD5D4');
        $this->addSql('DROP INDEX IDX_FB3314DA4296D31F ON water');
        $this->addSql('DROP INDEX IDX_FB3314DA9CECD5D4 ON water');
        $this->addSql('ALTER TABLE water DROP genre_id, DROP inventor_id');
    }
}
