<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150509212105 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE hello_test');
        $this->addSql('ALTER TABLE ns_Produit DROP FOREIGN KEY FK_E618D5BB3DA5256D');
        $this->addSql('DROP INDEX uniq_e618d5bbaea34913 ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_12F8480AAEA34913 ON ns_Produit (reference)');
        $this->addSql('DROP INDEX uniq_e618d5bb3da5256d ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_12F8480A3DA5256D ON ns_Produit (image_id)');
        $this->addSql('ALTER TABLE ns_Produit ADD CONSTRAINT FK_E618D5BB3DA5256D FOREIGN KEY (image_id) REFERENCES ns_Image (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_B314F22CF347EFB');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_B314F22C49AD7901');
        $this->addSql('DROP INDEX idx_b314f22c49ad7901 ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_8CA7DEF649AD7901 ON ns_ReassortProduit (reassort_id)');
        $this->addSql('DROP INDEX idx_b314f22cf347efb ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_8CA7DEF6F347EFB ON ns_ReassortProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_B314F22CF347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_B314F22C49AD7901 FOREIGN KEY (reassort_id) REFERENCES ns_Reassort (id)');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_80E01F9F347EFB');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_80E01F97DC7170A');
        $this->addSql('DROP INDEX idx_80e01f97dc7170a ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_B3B1ED3D7DC7170A ON ns_VenteProduit (vente_id)');
        $this->addSql('DROP INDEX idx_80e01f9f347efb ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_B3B1ED3DF347EFB ON ns_VenteProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_80E01F9F347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_80E01F97DC7170A FOREIGN KEY (vente_id) REFERENCES ns_Vente (id)');
        $this->addSql('DROP INDEX uniq_2da1797792fc23a8 ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7DF569D892FC23A8 ON ns_User (username_canonical)');
        $this->addSql('DROP INDEX uniq_2da17977a0d96fbf ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7DF569D8A0D96FBF ON ns_User (email_canonical)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hello_test (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ns_Produit DROP FOREIGN KEY FK_12F8480A3DA5256D');
        $this->addSql('DROP INDEX uniq_12f8480aaea34913 ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E618D5BBAEA34913 ON ns_Produit (reference)');
        $this->addSql('DROP INDEX uniq_12f8480a3da5256d ON ns_Produit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E618D5BB3DA5256D ON ns_Produit (image_id)');
        $this->addSql('ALTER TABLE ns_Produit ADD CONSTRAINT FK_12F8480A3DA5256D FOREIGN KEY (image_id) REFERENCES ns_Image (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF649AD7901');
        $this->addSql('ALTER TABLE ns_ReassortProduit DROP FOREIGN KEY FK_8CA7DEF6F347EFB');
        $this->addSql('DROP INDEX idx_8ca7def649ad7901 ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_B314F22C49AD7901 ON ns_ReassortProduit (reassort_id)');
        $this->addSql('DROP INDEX idx_8ca7def6f347efb ON ns_ReassortProduit');
        $this->addSql('CREATE INDEX IDX_B314F22CF347EFB ON ns_ReassortProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_8CA7DEF649AD7901 FOREIGN KEY (reassort_id) REFERENCES ns_Reassort (id)');
        $this->addSql('ALTER TABLE ns_ReassortProduit ADD CONSTRAINT FK_8CA7DEF6F347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
        $this->addSql('DROP INDEX uniq_7df569d892fc23a8 ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DA1797792FC23A8 ON ns_User (username_canonical)');
        $this->addSql('DROP INDEX uniq_7df569d8a0d96fbf ON ns_User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DA17977A0D96FBF ON ns_User (email_canonical)');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3D7DC7170A');
        $this->addSql('ALTER TABLE ns_VenteProduit DROP FOREIGN KEY FK_B3B1ED3DF347EFB');
        $this->addSql('DROP INDEX idx_b3b1ed3d7dc7170a ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_80E01F97DC7170A ON ns_VenteProduit (vente_id)');
        $this->addSql('DROP INDEX idx_b3b1ed3df347efb ON ns_VenteProduit');
        $this->addSql('CREATE INDEX IDX_80E01F9F347EFB ON ns_VenteProduit (produit_id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_B3B1ED3D7DC7170A FOREIGN KEY (vente_id) REFERENCES ns_Vente (id)');
        $this->addSql('ALTER TABLE ns_VenteProduit ADD CONSTRAINT FK_B3B1ED3DF347EFB FOREIGN KEY (produit_id) REFERENCES ns_Produit (id)');
    }
}
