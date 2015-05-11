<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150509193603 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('RENAME TABLE Produit TO ns_Produit');
        $this->addSql('RENAME TABLE Reassort TO ns_Reassort');
        $this->addSql('RENAME TABLE ReassortProduit TO ns_ReassortProduit');
        $this->addSql('RENAME TABLE User TO ns_User');
        $this->addSql('RENAME TABLE Vente TO ns_Vente');
        $this->addSql('RENAME TABLE VenteProduit TO ns_VenteProduit');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3D7DC7170A');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3DF347EFB');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF6F347EFB');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF649AD7901');
        $this->addSql('ALTER TABLE ns_Produit DROP FOREIGN KEY FK_12F8480A3DA5256D');
        $this->addSql('CREATE TABLE noonastock_Image (id INT AUTO_INCREMENT NOT NULL, extension VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, alt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_Produit (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, stock INT NOT NULL, isActif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D5642BA1AEA34913 (reference), UNIQUE INDEX UNIQ_D5642BA13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_Reassort (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, coutsDivers DOUBLE PRECISION NOT NULL, totalPrice DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_ReassortProduit (reassort_id INT NOT NULL, produit_id INT NOT NULL, coutTotal DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, INDEX IDX_F04F91A749AD7901 (reassort_id), INDEX IDX_F04F91A7F347EFB (produit_id), PRIMARY KEY(reassort_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, username_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C5CD5EE92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_C5CD5EEA0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_Vente (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, coutsDivers DOUBLE PRECISION NOT NULL, totalPrice DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noonastock_VenteProduit (vente_id INT NOT NULL, produit_id INT NOT NULL, coutTotal DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, INDEX IDX_ED671B4A7DC7170A (vente_id), INDEX IDX_ED671B4AF347EFB (produit_id), PRIMARY KEY(vente_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE noonastock_Produit ADD CONSTRAINT FK_D5642BA13DA5256D FOREIGN KEY (image_id) REFERENCES noonastock_Image (id)');
        $this->addSql('ALTER TABLE noonastock_ReassortProduit ADD CONSTRAINT FK_F04F91A7F347EFB FOREIGN KEY (produit_id) REFERENCES noonastock_Produit (id)');
        $this->addSql('ALTER TABLE noonastock_ReassortProduit ADD CONSTRAINT FK_F04F91A749AD7901 FOREIGN KEY (reassort_id) REFERENCES noonastock_Reassort (id)');
        $this->addSql('ALTER TABLE noonastock_VenteProduit ADD CONSTRAINT FK_ED671B4AF347EFB FOREIGN KEY (produit_id) REFERENCES noonastock_Produit (id)');
        $this->addSql('ALTER TABLE noonastock_VenteProduit ADD CONSTRAINT FK_ED671B4A7DC7170A FOREIGN KEY (vente_id) REFERENCES noonastock_Vente (id)');
        $this->addSql('DROP TABLE ns_Vente');
        $this->addSql('DROP TABLE ns_VenteProduit');
        $this->addSql('DROP TABLE ns_Produit');
        $this->addSql('DROP TABLE ns_Reassort');
        $this->addSql('DROP TABLE ns_Image');
        $this->addSql('DROP TABLE ns_ReassortProduit');
        $this->addSql('DROP TABLE ns_User');
    }
}
