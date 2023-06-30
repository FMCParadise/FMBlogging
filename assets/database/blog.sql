CREATE TABLE `authors` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `gpdr` boolean NOT NULL,
  `created_at` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `posts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) UNIQUE NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `author_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) UNIQUE NOT NULL,
  `slug` varchar(50) UNIQUE NOT NULL
);

CREATE TABLE `posts_categories` (
  `posts_id` int,
  `categories_id` int,
  PRIMARY KEY (`posts_id`, `categories_id`)
);

ALTER TABLE `posts` ADD FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);

ALTER TABLE `posts_categories` ADD FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`);

ALTER TABLE `posts_categories` ADD FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);
