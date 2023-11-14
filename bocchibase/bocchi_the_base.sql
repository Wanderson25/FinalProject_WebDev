CREATE TABLE `categories` (
  `category_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(100) NOT NULL
);
CREATE TABLE `songs` (
  `song_id` INT AUTO_INCREMENT PRIMARY KEY,
  `song_title` VARCHAR(100) NOT NULL,
  `song_artist` VARCHAR(100) NOT NULL,
  `song_duration` INT NOT NULL,
  `song_date` DATE,
  `song_url` VARCHAR(255) NOT NULL,
  `category_id` INT,
  `cover_url` VARCHAR(255),
  `song_db_id` VARCHAR(255),
  `song_view` INT DEFAULT 1,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`category_id`)
);

CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_name` VARCHAR(50) NOT NULL,
  `user_email` VARCHAR(100) UNIQUE NOT NULL,
  `user_password` VARCHAR(50) NOT NULL,
  `user_role` ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE `comments` (
  `comment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `comment_text` VARCHAR(255) NOT NULL,
  `comment_date` DATE NOT NULL,
  `user_id` INT,
  `song_id` INT,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`song_id`) REFERENCES `songs`(`song_id`)
);

CREATE TABLE `playlists` (
  `playlist_id` INT AUTO_INCREMENT PRIMARY KEY,
  `playlist_name` VARCHAR(100) NOT NULL,
  `playlist_date` DATE NOT NULL,
  `user_id` INT,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);


CREATE TABLE `playlist_songs` (
  `playlist_song_id` INT AUTO_INCREMENT PRIMARY KEY,
  `playlist_id` INT,
  `song_id` INT,
  FOREIGN KEY (`playlist_id`) REFERENCES `playlists`(`playlist_id`),
  FOREIGN KEY (`song_id`) REFERENCES `songs`(`song_id`),
  UNIQUE (`playlist_id`, `song_id`)
);

CREATE TABLE `lyrics` (
  `lyrics_id` INT AUTO_INCREMENT PRIMARY KEY,
  `song_id` INT,
  `lyrics_txt` LONGTEXT,
  FOREIGN KEY (`song_id`) REFERENCES `songs`(`song_id`)
);

CREATE TABLE `user_likes` (
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`song_id`),
  KEY `song_id` (`song_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
);

ALTER TABLE songs ADD FULLTEXT(song_title, song_artist);