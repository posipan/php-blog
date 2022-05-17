-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Database blog
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `blog` ;

CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog` ;

START TRANSACTION;

SET time_zone = "+09:00";

-- -----------------------------------------------------
-- Table `blog`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog`.`users` ;

CREATE TABLE IF NOT EXISTS `blog`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(15) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `blog`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog`.`posts` ;

CREATE TABLE IF NOT EXISTS `blog`.`posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(80) NOT NULL,
  `image` VARCHAR(2083) NULL,
  `content` LONGTEXT NOT NULL,
  `status` INT NOT NULL DEFAULT 0 COMMENT '公開: 1, 下書き: 0',
  `user_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_post_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `blog`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `blog`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog`.`categories` ;

CREATE TABLE IF NOT EXISTS `blog`.`categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC) VISIBLE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `blog`.`category_relationships`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog`.`category_relationships` ;

CREATE TABLE IF NOT EXISTS `blog`.`category_relationships` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `post_id`, `category_id`),
  INDEX `fk_post_has_categories_post1_idx` (`post_id` ASC) VISIBLE,
  INDEX `fk_post_has_categories_category1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_post_has_categories_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `blog`.`posts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_categories_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `blog`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
-- Dumping data for table user
--
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'panda', 'panda@example.com', '$2y$10$x1n7IuRKaFNvjI77Sy7Ntu6CQqF00c7rQaGlwACZKA6LrDKPotX2.'),
(2, 'cat', 'cat@example.com', '$2y$10$x1n7IuRKaFNvjI77Sy7Ntu6CQqF00c7rQaGlwACZKA6LrDKPotX2.'),
(3, 'dog123', 'dog123@example.com', '$2y$10$x1n7IuRKaFNvjI77Sy7Ntu6CQqF00c7rQaGlwACZKA6LrDKPotX2.');

--
-- Dumping data for table posts
--
INSERT INTO `posts` (`id`, `title`, `image`, `content`, `status`, `user_id`) VALUES
(1, 'テストタイトル1', 'img01.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 1),
(2, 'テストタイトル2', 'img02.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 2),
(3, 'テストタイトル3', 'img03.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 0, 3),
(4, 'テストタイトル4', 'img04.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 1),
(5, 'テストタイトル5', 'img05.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 2),
(6, 'テストタイトル6', 'img06.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 3),
(7, 'テストタイトル7', 'img07.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 0, 1),
(8, 'テストタイトル8', 'img08.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 2),
(9, 'テストタイトル9', 'img09.jpg', '## サンプル\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n## コード解説\n### HTML\n#### PUG\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.\n### CSS\nLorem ipsum dolor sit amet consectetur adipisicing elit. Saepe eveniet molestias doloremque ea similique facilis odio? Consequuntur quibusdam expedita optio consequatur, ab, velit aspernatur mollitia est eius, totam aut impedit.', 1, 3);

--
-- Dumping data for table category
--
INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, '旅行', 'travel'),
(2, 'ファッション', 'fashion'),
(3, 'エンタメ', 'entertainment'),
(4, 'スポーツ', 'sports'),
(5, '政治・経済', 'political-economy'),
(6, 'マネー', 'money'),
(7, 'IT', 'it');

--
-- Dumping data for table category_relationships
--
INSERT INTO `category_relationships` (`id`, `post_id`, `category_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 7),
(4, 4, 6),
(5, 5, 3),
(6, 6, 5),
(7, 7, 1),
(8, 8, 7),
(9, 9, 6);

COMMIT;
