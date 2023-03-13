<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313181039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id VARCHAR(10) NOT NULL, country VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE geolocation (id INT AUTO_INCREMENT NOT NULL, station_id VARCHAR(10) NOT NULL, country_id VARCHAR(10) NOT NULL, island VARCHAR(100) DEFAULT NULL, county VARCHAR(100) DEFAULT NULL, place VARCHAR(100) DEFAULT NULL, hamlet VARCHAR(100) DEFAULT NULL, town VARCHAR(100) DEFAULT NULL, municipality VARCHAR(100) DEFAULT NULL, state_district VARCHAR(100) DEFAULT NULL, administrative VARCHAR(100) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, village VARCHAR(100) DEFAULT NULL, region VARCHAR(100) DEFAULT NULL, province VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, locality VARCHAR(100) DEFAULT NULL, postcode VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_9DC0E5B421BDB235 (station_id), INDEX IDX_9DC0E5B4F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nearest_location (id INT AUTO_INCREMENT NOT NULL, station_id VARCHAR(10) NOT NULL, country_id VARCHAR(10) NOT NULL, name VARCHAR(100) DEFAULT NULL, administrative_region1 VARCHAR(100) DEFAULT NULL, administrative_region2 VARCHAR(100) DEFAULT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_F17FBE8C21BDB235 (station_id), INDEX IDX_F17FBE8CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id VARCHAR(10) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, elevation DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', subscription_id INT DEFAULT NULL, username VARCHAR(45) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_8D93D6499A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE geolocation ADD CONSTRAINT FK_9DC0E5B421BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE geolocation ADD CONSTRAINT FK_9DC0E5B4F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE nearest_location ADD CONSTRAINT FK_F17FBE8C21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE nearest_location ADD CONSTRAINT FK_F17FBE8CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE geolocation DROP FOREIGN KEY FK_9DC0E5B421BDB235');
        $this->addSql('ALTER TABLE geolocation DROP FOREIGN KEY FK_9DC0E5B4F92F3E70');
        $this->addSql('ALTER TABLE nearest_location DROP FOREIGN KEY FK_F17FBE8C21BDB235');
        $this->addSql('ALTER TABLE nearest_location DROP FOREIGN KEY FK_F17FBE8CF92F3E70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499A1887DC');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE geolocation');
        $this->addSql('DROP TABLE nearest_location');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
    }
}
