<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180515151816 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sport VARCHAR(255) NOT NULL, created DATETIME NOT NULL, home_team_name VARCHAR(255) NOT NULL, away_team_name VARCHAR(255) NOT NULL, unibet_id VARCHAR(255) NOT NULL, competition_name VARCHAR(255) DEFAULT NULL, competition_id INT DEFAULT NULL, is_live TINYINT(1) NOT NULL, url VARCHAR(255) NOT NULL, home_score INT NOT NULL, away_score INT NOT NULL, chrono INT NOT NULL, period VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, created DATETIME NOT NULL, market_name VARCHAR(255) NOT NULL, home_selection_name VARCHAR(255) DEFAULT NULL, home_rate DOUBLE PRECISION DEFAULT NULL, away_selection_name VARCHAR(255) DEFAULT NULL, away_rate DOUBLE PRECISION DEFAULT NULL, draw_rate DOUBLE PRECISION DEFAULT NULL, home_score INT NOT NULL, away_score INT NOT NULL, chrono INT NOT NULL, period VARCHAR(255) NOT NULL, INDEX IDX_FBF0EC9BE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BE48FD905');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE bet');
    }
}
