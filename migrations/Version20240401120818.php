<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240401120818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E6671DF2E6E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_famille_id INTEGER NOT NULL, reference VARCHAR(10) NOT NULL COLLATE BINARY, designation VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, cover_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, price NUMERIC(12, 2) NOT NULL, updated_at DATETIME DEFAULT NULL, price_professional NUMERIC(12, 2) DEFAULT NULL, price_dealer NUMERIC(12, 2) DEFAULT NULL, CONSTRAINT FK_23A0E6671DF2E6E FOREIGN KEY (sous_famille_id) REFERENCES sous_famille (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer) SELECT id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6671DF2E6E ON article (sous_famille_id)');
        $this->addSql('DROP INDEX IDX_EFE84AD1354DE8F3');
        $this->addSql('DROP INDEX IDX_EFE84AD12CA8B87C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_article AS SELECT article_source, article_target FROM article_article');
        $this->addSql('DROP TABLE article_article');
        $this->addSql('CREATE TABLE article_article (article_source INTEGER NOT NULL, article_target INTEGER NOT NULL, PRIMARY KEY(article_source, article_target), CONSTRAINT FK_EFE84AD1354DE8F3 FOREIGN KEY (article_source) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EFE84AD12CA8B87C FOREIGN KEY (article_target) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article_article (article_source, article_target) SELECT article_source, article_target FROM __temp__article_article');
        $this->addSql('DROP TABLE __temp__article_article');
        $this->addSql('CREATE INDEX IDX_EFE84AD1354DE8F3 ON article_article (article_source)');
        $this->addSql('CREATE INDEX IDX_EFE84AD12CA8B87C ON article_article (article_target)');
        $this->addSql('DROP INDEX IDX_1C52F95897A77B84');
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id, famille_id, libelle, logo, updated_at FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, famille_id INTEGER NOT NULL, libelle VARCHAR(25) NOT NULL COLLATE BINARY, logo VARCHAR(50) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_1C52F95897A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO brand (id, famille_id, libelle, logo, updated_at) SELECT id, famille_id, libelle, logo, updated_at FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('CREATE INDEX IDX_1C52F95897A77B84 ON brand (famille_id)');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, user_id, created_at, rating, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, user_id INTEGER NOT NULL, created_at DATETIME NOT NULL, rating INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, article_id, user_id, created_at, rating, content) SELECT id, article_id, user_id, created_at, rating, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('DROP INDEX IDX_C53D045F7294869C');
        $this->addSql('DROP INDEX IDX_C53D045F3B69A9AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, article_id, variant_id, caption, updated_at, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, variant_id INTEGER DEFAULT NULL, caption VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, url VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C53D045F3B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, article_id, variant_id, caption, updated_at, url) SELECT id, article_id, variant_id, caption, updated_at, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F7294869C ON image (article_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F3B69A9AF ON image (variant_id)');
        $this->addSql('DROP INDEX IDX_F52993989395C3F3');
        $this->addSql('DROP INDEX IDX_F5299398896DBBDE');
        $this->addSql('DROP INDEX IDX_F52993986BF700BD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, customer_id, status_id, updated_by_id, created_at, updated_at, amount, reference FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, status_id INTEGER NOT NULL, updated_by_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, amount NUMERIC(12, 2) NOT NULL, reference VARCHAR(10) NOT NULL COLLATE BINARY, CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5299398896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "order" (id, customer_id, status_id, updated_by_id, created_at, updated_at, amount, reference) SELECT id, customer_id, status_id, updated_by_id, created_at, updated_at, amount, reference FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON "order" (customer_id)');
        $this->addSql('CREATE INDEX IDX_F5299398896DBBDE ON "order" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F52993986BF700BD ON "order" (status_id)');
        $this->addSql('DROP INDEX IDX_ED896F462B1C2395');
        $this->addSql('DROP INDEX IDX_ED896F467294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order_detail AS SELECT id, article_id, related_order_id, price, quantity, sub_total, sequence FROM order_detail');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('CREATE TABLE order_detail (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, related_order_id INTEGER NOT NULL, price NUMERIC(12, 2) NOT NULL, quantity INTEGER NOT NULL, sub_total NUMERIC(12, 2) NOT NULL, sequence INTEGER NOT NULL, CONSTRAINT FK_ED896F467294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_ED896F462B1C2395 FOREIGN KEY (related_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO order_detail (id, article_id, related_order_id, price, quantity, sub_total, sequence) SELECT id, article_id, related_order_id, price, quantity, sub_total, sequence FROM __temp__order_detail');
        $this->addSql('DROP TABLE __temp__order_detail');
        $this->addSql('CREATE INDEX IDX_ED896F462B1C2395 ON order_detail (related_order_id)');
        $this->addSql('CREATE INDEX IDX_ED896F467294869C ON order_detail (article_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL COLLATE BINARY, hashed_token VARCHAR(100) NOT NULL COLLATE BINARY, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_77A8A5E97A77B84');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sous_famille AS SELECT id, famille_id, cover_image, updated_at, sous_famille FROM sous_famille');
        $this->addSql('DROP TABLE sous_famille');
        $this->addSql('CREATE TABLE sous_famille (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, famille_id INTEGER NOT NULL, cover_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, sous_famille VARCHAR(75) NOT NULL COLLATE BINARY, CONSTRAINT FK_77A8A5E97A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO sous_famille (id, famille_id, cover_image, updated_at, sous_famille) SELECT id, famille_id, cover_image, updated_at, sous_famille FROM __temp__sous_famille');
        $this->addSql('DROP TABLE __temp__sous_famille');
        $this->addSql('CREATE INDEX IDX_77A8A5E97A77B84 ON sous_famille (famille_id)');
        $this->addSql('DROP INDEX IDX_2DE8C6A3A76ED395');
        $this->addSql('DROP INDEX IDX_2DE8C6A3D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_role AS SELECT user_id, role_id FROM user_role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('CREATE TABLE user_role (user_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(user_id, role_id), CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_role (user_id, role_id) SELECT user_id, role_id FROM __temp__user_role');
        $this->addSql('DROP TABLE __temp__user_role');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('DROP INDEX IDX_F143BFAD7294869C');
        $this->addSql('DROP INDEX IDX_F143BFAD7ADA1FB5');
        $this->addSql('DROP INDEX IDX_F143BFAD498DA827');
        $this->addSql('DROP INDEX IDX_F143BFAD44F5D008');
        $this->addSql('CREATE TEMPORARY TABLE __temp__variant AS SELECT id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer FROM variant');
        $this->addSql('DROP TABLE variant');
        $this->addSql('CREATE TABLE variant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, size_id INTEGER NOT NULL, color_id INTEGER NOT NULL, article_id INTEGER DEFAULT NULL, brand_id INTEGER DEFAULT NULL, reference VARCHAR(10) NOT NULL COLLATE BINARY, price NUMERIC(12, 2) NOT NULL, discounted BOOLEAN DEFAULT NULL, discount NUMERIC(3, 2) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, stock BOOLEAN DEFAULT NULL, price_professional NUMERIC(12, 2) DEFAULT NULL, price_dealer NUMERIC(12, 2) DEFAULT NULL, CONSTRAINT FK_F143BFAD498DA827 FOREIGN KEY (size_id) REFERENCES size (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F143BFAD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F143BFAD7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F143BFAD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO variant (id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer) SELECT id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer FROM __temp__variant');
        $this->addSql('DROP TABLE __temp__variant');
        $this->addSql('CREATE INDEX IDX_F143BFAD7294869C ON variant (article_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD7ADA1FB5 ON variant (color_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD498DA827 ON variant (size_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD44F5D008 ON variant (brand_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E6671DF2E6E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_famille_id INTEGER NOT NULL, reference VARCHAR(10) NOT NULL, designation VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, price NUMERIC(12, 2) NOT NULL, updated_at DATETIME DEFAULT NULL, price_professional NUMERIC(12, 2) DEFAULT NULL, price_dealer NUMERIC(12, 2) DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer) SELECT id, sous_famille_id, reference, designation, description, cover_image, slug, price, updated_at, price_professional, price_dealer FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6671DF2E6E ON article (sous_famille_id)');
        $this->addSql('DROP INDEX IDX_EFE84AD1354DE8F3');
        $this->addSql('DROP INDEX IDX_EFE84AD12CA8B87C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_article AS SELECT article_source, article_target FROM article_article');
        $this->addSql('DROP TABLE article_article');
        $this->addSql('CREATE TABLE article_article (article_source INTEGER NOT NULL, article_target INTEGER NOT NULL, PRIMARY KEY(article_source, article_target))');
        $this->addSql('INSERT INTO article_article (article_source, article_target) SELECT article_source, article_target FROM __temp__article_article');
        $this->addSql('DROP TABLE __temp__article_article');
        $this->addSql('CREATE INDEX IDX_EFE84AD1354DE8F3 ON article_article (article_source)');
        $this->addSql('CREATE INDEX IDX_EFE84AD12CA8B87C ON article_article (article_target)');
        $this->addSql('DROP INDEX IDX_1C52F95897A77B84');
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id, famille_id, libelle, logo, updated_at FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, famille_id INTEGER NOT NULL, libelle VARCHAR(25) NOT NULL, logo VARCHAR(50) DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO brand (id, famille_id, libelle, logo, updated_at) SELECT id, famille_id, libelle, logo, updated_at FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('CREATE INDEX IDX_1C52F95897A77B84 ON brand (famille_id)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, user_id, created_at, rating, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, user_id INTEGER NOT NULL, created_at DATETIME NOT NULL, rating INTEGER NOT NULL, content CLOB NOT NULL)');
        $this->addSql('INSERT INTO comment (id, article_id, user_id, created_at, rating, content) SELECT id, article_id, user_id, created_at, rating, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('DROP INDEX IDX_C53D045F7294869C');
        $this->addSql('DROP INDEX IDX_C53D045F3B69A9AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, article_id, variant_id, caption, updated_at, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, variant_id INTEGER DEFAULT NULL, caption VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO image (id, article_id, variant_id, caption, updated_at, url) SELECT id, article_id, variant_id, caption, updated_at, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F7294869C ON image (article_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F3B69A9AF ON image (variant_id)');
        $this->addSql('DROP INDEX IDX_F52993989395C3F3');
        $this->addSql('DROP INDEX IDX_F5299398896DBBDE');
        $this->addSql('DROP INDEX IDX_F52993986BF700BD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, customer_id, updated_by_id, status_id, created_at, reference, updated_at, amount FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, updated_by_id INTEGER DEFAULT NULL, status_id INTEGER NOT NULL, created_at DATETIME NOT NULL, reference VARCHAR(10) NOT NULL, updated_at DATETIME DEFAULT NULL, amount NUMERIC(12, 2) NOT NULL)');
        $this->addSql('INSERT INTO "order" (id, customer_id, updated_by_id, status_id, created_at, reference, updated_at, amount) SELECT id, customer_id, updated_by_id, status_id, created_at, reference, updated_at, amount FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON "order" (customer_id)');
        $this->addSql('CREATE INDEX IDX_F5299398896DBBDE ON "order" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F52993986BF700BD ON "order" (status_id)');
        $this->addSql('DROP INDEX IDX_ED896F467294869C');
        $this->addSql('DROP INDEX IDX_ED896F462B1C2395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order_detail AS SELECT id, article_id, related_order_id, price, quantity, sub_total, sequence FROM order_detail');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('CREATE TABLE order_detail (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, related_order_id INTEGER NOT NULL, price NUMERIC(12, 2) NOT NULL, quantity INTEGER NOT NULL, sub_total NUMERIC(12, 2) NOT NULL, sequence INTEGER NOT NULL)');
        $this->addSql('INSERT INTO order_detail (id, article_id, related_order_id, price, quantity, sub_total, sequence) SELECT id, article_id, related_order_id, price, quantity, sub_total, sequence FROM __temp__order_detail');
        $this->addSql('DROP TABLE __temp__order_detail');
        $this->addSql('CREATE INDEX IDX_ED896F467294869C ON order_detail (article_id)');
        $this->addSql('CREATE INDEX IDX_ED896F462B1C2395 ON order_detail (related_order_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_77A8A5E97A77B84');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sous_famille AS SELECT id, famille_id, cover_image, updated_at, sous_famille FROM sous_famille');
        $this->addSql('DROP TABLE sous_famille');
        $this->addSql('CREATE TABLE sous_famille (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, famille_id INTEGER NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, sous_famille VARCHAR(75) NOT NULL)');
        $this->addSql('INSERT INTO sous_famille (id, famille_id, cover_image, updated_at, sous_famille) SELECT id, famille_id, cover_image, updated_at, sous_famille FROM __temp__sous_famille');
        $this->addSql('DROP TABLE __temp__sous_famille');
        $this->addSql('CREATE INDEX IDX_77A8A5E97A77B84 ON sous_famille (famille_id)');
        $this->addSql('DROP INDEX IDX_2DE8C6A3A76ED395');
        $this->addSql('DROP INDEX IDX_2DE8C6A3D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_role AS SELECT user_id, role_id FROM user_role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('CREATE TABLE user_role (user_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(user_id, role_id))');
        $this->addSql('INSERT INTO user_role (user_id, role_id) SELECT user_id, role_id FROM __temp__user_role');
        $this->addSql('DROP TABLE __temp__user_role');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('DROP INDEX IDX_F143BFAD498DA827');
        $this->addSql('DROP INDEX IDX_F143BFAD7ADA1FB5');
        $this->addSql('DROP INDEX IDX_F143BFAD7294869C');
        $this->addSql('DROP INDEX IDX_F143BFAD44F5D008');
        $this->addSql('CREATE TEMPORARY TABLE __temp__variant AS SELECT id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer FROM variant');
        $this->addSql('DROP TABLE variant');
        $this->addSql('CREATE TABLE variant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, size_id INTEGER NOT NULL, color_id INTEGER NOT NULL, article_id INTEGER DEFAULT NULL, brand_id INTEGER DEFAULT NULL, reference VARCHAR(10) NOT NULL, price NUMERIC(12, 2) NOT NULL, discounted BOOLEAN DEFAULT NULL, discount NUMERIC(3, 2) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, stock BOOLEAN DEFAULT NULL, price_professional NUMERIC(12, 2) DEFAULT NULL, price_dealer NUMERIC(12, 2) DEFAULT NULL)');
        $this->addSql('INSERT INTO variant (id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer) SELECT id, size_id, color_id, article_id, brand_id, reference, price, discounted, discount, updated_at, image, stock, price_professional, price_dealer FROM __temp__variant');
        $this->addSql('DROP TABLE __temp__variant');
        $this->addSql('CREATE INDEX IDX_F143BFAD498DA827 ON variant (size_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD7ADA1FB5 ON variant (color_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD7294869C ON variant (article_id)');
        $this->addSql('CREATE INDEX IDX_F143BFAD44F5D008 ON variant (brand_id)');
    }
}
