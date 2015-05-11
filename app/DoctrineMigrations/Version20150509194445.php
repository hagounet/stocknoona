<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150509194445 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('RENAME TABLE Image TO ns_Image');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ns_Produit DROP FOREIGN KEY FK_12F8480A3DA5256D');
        $this->addSql('CREATE TABLE noonastock_Image (id INT AUTO_INCREMENT NOT NULL, extension VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, alt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE ns_Image');
        $this->addSql('ALTER TABLE ns_Produit DROP FOREIGN KEY FK_12F8480A3DA5256D');
        $this->addSql('ALTER TABLE ns_Produit ADD CONSTRAINT FK_D5642BA13DA5256D FOREIGN KEY (image_id) REFERENCES noonastock_Image (id)');
        $this->addSql('DROP INDEX uniq_12f8480aaea34913 ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5642BA1AEA34913 ON ns_Produit (reference)');
        $this->addSql('DROP INDEX uniq_12f8480a3da5256d ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5642BA13DA5256D ON ns_Produit (image_id)');
        $this->addSql('ALTER TABLE ns_Produit ADD CONSTRAINT FK_12F8480A3DA5256D FOREIGN KEY (image_id) REFERENCES ns_Image (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF649AD7901');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF6F347EFB');
        $this->addSql('DROP INDEX idx_8ca7def649ad7901 ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_F04F91A749AD7901 ON ns_ReassortProduit (reassort_id)');
        $this->addSql('DROP INDEX idx_8ca7def6f347efb ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_F04F91A7F347EFB ON ns_ReassortProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_8CA7DEF649AD7901 FOREIGN KEY (reassort_id) REFERENCES ns_Reassort (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_8CA7DEF6F347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
        $this->addSql('DROP INDEX uniq_7df569d892fc23a8 ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5CD5EE92FC23A8 ON ns_User (username_canonical)');
        $this->addSql('DROP INDEX uniq_7df569d8a0d96fbf ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5CD5EEA0D96FBF ON ns_User (email_canonical)');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3D7DC7170A');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3DF347EFB');
        $this->addSql('DROP INDEX idx_b3b1ed3d7dc7170a ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_ED671B4A7DC7170A ON ns_VenteProduit (vente_id)');
        $this->addSql('DROP INDEX idx_b3b1ed3df347efb ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_ED671B4AF347EFB ON ns_VenteProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_B3B1ED3D7DC7170A FOREIGN KEY (vente_id) REFERENCES ns_Vente (id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_B3B1ED3DF347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
    }
}
