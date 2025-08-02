-- USERS TABLE

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ROLES TABLE

CREATE TABLE `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `roles`

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'user'),
(2, 'editor'),
(3, 'admin');


-- USER_ROLES TABLE

CREATE TABLE `user_roles` (
  `user_id` INT(11) NOT NULL,
  `role_id` INT(11) NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- -----------------------------------------------

-- GENRES TABLE

CREATE TABLE `genres` (
  `genre_id` INT(11) NOT NULL AUTO_INCREMENT,
  `genre_name` VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `genres`

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Adventure'),
(2, 'Comedy'),
(3, 'Drama'),
(4, 'Fantasy'),
(5, 'Horror'),
(6, 'Romance'),
(7, 'Sci-Fi'),
(8, 'Thriller');


-- MOVIES TABLE

CREATE TABLE `movies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `movie_name` VARCHAR(255) NOT NULL,
  `release_date` DATE DEFAULT NULL,
  `movie_votes` INT(11) DEFAULT 0,
  `image` VARCHAR(255) DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` TEXT DEFAULT NULL,
  `background_image` VARCHAR(255) DEFAULT NULL,
  `author` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `movies`

INSERT INTO `movies` (`id`, `movie_name`, `release_date`, `movie_votes`, `image`, `type`, `created_at`, `description`, `background_image`, `author`) VALUES
(1, 'Akira', '1988-07-16', 8254, 'akira.jpg', 'Movie', '2025-07-29 05:18:17', 'A groundbreaking anime set in post-apocalyptic Neo-Tokyo, Akira follows a teen with uncontrollable psychic powers. As the government loses control, chaos erupts across the city. With themes of rebellion, corruption, and identity, the film became iconic for its animation, atmosphere, and cultural impact. It redefined anime worldwide and remains a cornerstone of sci-fi storytelling.', 'akira.jpg', 'Katsuhiro Otomo'),
(2, 'A Silent Voice', '2016-09-17', 7231, 'a-silent-voice.jpg', 'Movie', '2025-07-29 05:18:17', 'A Silent Voice explores themes of bullying, redemption, and friendship. Shoya, a former bully, seeks forgiveness from Shoko, a deaf girl he once tormented. Through deep emotional struggles, the story reveals how kindness and understanding can heal even the deepest wounds. Beautifully animated and profoundly moving, this film highlights the importance of empathy and second chances.', 'a-silent-voice.jpg', 'Naoko Yamada'),
(3, 'Attack on Titan', '2013-04-06', 9682, 'attack-on-titan.jpg', 'Series', '2025-07-29 05:18:17', 'In a world where giant man-eating Titans rule, humanity’s last survivors live behind massive walls. When the walls are breached, Eren Yeager and his friends join the military to fight back. Attack on Titan explores survival, freedom, and the darkness of war, packed with action, mystery, and shocking twists that have captivated fans worldwide.', 'attack-on-titan.jpg', 'Hajime Isayama'),
(4, 'Death Note', '2006-10-04', 8123, 'death-note.jpg', 'series', '2025-07-29 05:18:17', 'Death Note tells the story of Light Yagami, a brilliant student who gains a notebook that kills anyone whose name is written in it. He becomes a vigilante known as Kira, aiming to cleanse the world of evil. A gripping battle of wits ensues with detective L, questioning morality, justice, and the corruption of power.', 'death-note.jpg', 'Tetsurō Araki'),
(5, 'Demon Slayer', '2019-04-06', 9032, 'demon-slayer.jpg', 'Series', '2025-07-29 05:18:17', 'After his family is slaughtered by demons, Tanjiro Kamado becomes a Demon Slayer to save his sister Nezuko, who has been turned into a demon. With breathtaking animation, intense battles, and emotional depth, Demon Slayer explores themes of family, perseverance, and humanity in a beautifully crafted fantasy world filled with darkness and hope.', 'demon-slayer.jpg', 'Haruo Sotozaki'),
(6, 'Fullmetal Alchemist: Brotherhood', '2009-04-05', 7901, 'fullmetal-alchemist-brotherhood.jpg', 'Series', '2025-07-29 05:18:17', 'Two brothers, Edward and Alphonse Elric, use forbidden alchemy to resurrect their mother, paying a terrible price. They journey to restore their bodies by seeking the Philosopher’s Stone. This anime masterfully blends deep philosophical questions with action, sacrifice, and moral dilemmas, delivering one of the most compelling and emotionally powerful stories in anime history.', 'fullmetal-alchemist-brotherhood.jpg', 'Yasuhiro Irie'),
(7, 'Hunter x Hunter', '2011-10-02', 8842, 'hunter-hunter.jpg', 'Series', '2025-07-29 05:18:17', 'Gon Freecss sets out to become a Hunter to find his missing father. Along the way, he makes friends and faces dangerous challenges in a complex world full of adventure, strategy, and dark truths. Hunter x Hunter is known for its clever storytelling, unpredictable plot, and deep emotional and psychological development of characters.', 'hunter-hunter.jpg', 'Hiroshi Kōjina'),
(8, 'My Neighbor Totoro', '1988-04-16', 7589, 'my-neighbor-totoro.jpg', 'Movie', '2025-07-29 05:18:17', 'This whimsical tale follows two sisters who move to the countryside and encounter magical forest spirits, including the gentle Totoro. With a serene tone and beautiful nature-filled visuals, My Neighbor Totoro celebrates childhood wonder, imagination, and the healing power of nature. A timeless masterpiece loved by all generations for its simplicity and warmth.', 'my-neighbor-totoro.jpg', 'Hayao Miyazaki'),
(9, 'Naruto', '2002-10-03', 9991, 'naruto.jpg', 'Series', '2025-07-29 05:18:17', 'Naruto Uzumaki, a mischievous ninja with dreams of becoming Hokage, trains hard to gain recognition and protect his village. Along the way, he builds strong friendships and faces enemies while uncovering the secrets of his past. Naruto is an inspiring tale of perseverance, loyalty, and never giving up despite overwhelming odds and personal pain.', 'naruto.jpg', 'Masashi Kishimoto'),
(10, 'One Piece', '1999-10-20', 9780, 'one-piece.jpg', 'Series', '2025-07-29 05:18:17', 'Monkey D. Luffy and his crew sail the Grand Line in search of the ultimate treasure—the One Piece. With unforgettable characters, epic battles, and deep emotional arcs, One Piece combines humor, adventure, and heart like no other. It stands as one of the longest-running and most beloved anime series ever made.', 'one-piece.jpg', 'Eiichiro Oda'),
(11, 'Spirited Away', '2001-07-20', 9505, 'spirited-away.jpg', 'Movie', '2025-07-29 05:18:17', 'Chihiro stumbles into a mystical world of spirits after her parents are transformed into pigs. She must navigate this strange realm, work in a bathhouse, and find a way to return home. Spirited Away is a stunning, surreal masterpiece filled with imagination, symbolism, and emotional depth, winning international acclaim and an Academy Award.', 'spirited-away.jpg', 'Hayao Miyazaki'),
(12, 'Suzume', '2022-11-11', 7077, 'suzume.jpg', 'Movie', '2025-07-29 05:18:17', 'A teenager named Suzume helps a mysterious boy close supernatural doors that unleash disasters. As they travel across Japan, she faces emotional memories and unearthly challenges. With rich visuals, heartfelt moments, and magical realism, Suzume is a tale of healing, connection, and the emotional scars left behind by loss and disaster.', 'suzume.jpg', 'Makoto Shinkai'),
(13, 'Sword Art Online: Ordinal Scale', '2017-02-18', 8640, 'sword-art-online-ordinal-scale.jpg', 'Movie', '2025-07-29 05:18:17', 'In a near future, players dive into augmented reality with the game Ordinal Scale. But as strange events begin occurring, Kirito and his friends must face new dangers. Blending action, romance, and futuristic tech, this film explores memory, loyalty, and the boundary between the virtual and real world in gripping fashion.', 'sword-art-online-ordinal-scale.jpg', 'Tomohiko Itō'),
(14, 'The Promised Neverland', '2019-01-11', 8769, 'the-promised-nerverland.jpg', 'Series', '2025-07-29 05:18:17', 'At a peaceful orphanage, children live happy lives—until they discover a horrifying secret. Emma, Norman, and Ray must plan a daring escape. The Promised Neverland blends psychological horror with suspense, focusing on trust, intellect, and survival. It’s a chilling and emotional series that keeps viewers on edge from the first episode.', 'the-promised-neverland.jpg', 'Mamoru Kanbe'),
(15, 'Tokyo Ghoul', '2014-07-04', 8311, 'tokyo-ghoul.jpg', 'Series', '2025-07-29 05:18:17', 'Ken Kaneki becomes half-ghoul after a fateful encounter and must adapt to a world of monsters hiding among humans. Torn between two lives, he struggles with identity, morality, and survival. Tokyo Ghoul is a dark, emotional journey filled with action, tragedy, and philosophical questions about what it means to be human.', 'tokyo-ghoul.jpg', 'Shuhei Morita'),
(16, 'Weathering with You', '2019-07-19', 7888, 'weathering-with-you.jpg', 'Movie', '2025-07-29 05:18:17', 'A runaway boy meets a girl who can manipulate weather. As Tokyo faces endless rain, their bond grows—and so do the consequences of altering nature. Weathering with You is a visually stunning love story about climate, fate, and sacrifice, wrapped in magical realism and deeply emotional storytelling.', 'weathering-with-you.jpg', 'Makoto Shinkai'),
(17, 'Whisper of the Heart', '1995-07-15', 7195, 'whisper-of-the-heart.jpg', 'Movie', '2025-07-29 05:18:17', 'A curious teenage girl named Shizuku discovers a mysterious antique shop and meets a boy chasing his dreams of becoming a violin maker. Inspired by his passion, she begins her own creative journey. Whisper of the Heart is a tender coming-of-age story that explores dreams, love, and the courage to follow one’s passion.', 'whisper-of-the-heart.jpg', 'Yoshifumi Kondō'),
(18, 'Your Name', '2016-08-26', 9650, 'your-name.jpg', 'Movie', '2025-07-29 05:18:17', 'Two strangers mysteriously begin swapping bodies, discovering a deep connection across time and space. As they search for each other, a dramatic twist threatens everything. Your Name blends romance, fantasy, and fate in a breathtaking narrative that moved millions with its emotional depth, stunning animation, and unforgettable soundtrack.', 'your-name.jpg', 'Makoto Shinkai'),
(19, 'Ponyo', '2008-07-19', 0, 'ponyo.jpeg', 'Movie', '2025-07-29 10:52:38', 'When Sosuke, a young boy who lives on a clifftop overlooking the sea, rescues a stranded goldfish named Ponyo, he discovers more than he bargained for. Ponyo is a curious, energetic young creature who yearns to be human, but even as she causes chaos around the house, her father, a powerful sorcerer, schemes to return Ponyo to the sea.', 'ponyo.jpg', 'Hayao Miyazaki');


-- MOVIE_GENRES TABLE

CREATE TABLE `movie_genres` (
  `movie_id` INT(11) NOT NULL,
  `genre_id` INT(11) NOT NULL,
  PRIMARY KEY (`movie_id`, `genre_id`),
  FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`genre_id`) REFERENCES `genres`(`genre_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Dumping data for table `movie_genres`

INSERT INTO `movie_genres` (`movie_id`, `genre_id`) VALUES
(1, 1),
(1, 7),
(1, 8),
(2, 3),
(2, 6),
(3, 1),
(3, 8),
(4, 3),
(4, 5),
(4, 8),
(5, 1),
(5, 4),
(5, 5),
(6, 1),
(6, 3),
(6, 4),
(7, 1),
(7, 4),
(8, 1),
(8, 2),
(8, 4),
(9, 1),
(9, 2),
(9, 4),
(10, 1),
(10, 2),
(11, 1),
(11, 3),
(11, 4),
(12, 3),
(12, 4),
(12, 6),
(13, 1),
(13, 6),
(13, 7),
(14, 3),
(14, 5),
(14, 8),
(15, 3),
(15, 5),
(15, 8),
(16, 3),
(16, 4),
(16, 6),
(17, 3),
(17, 6),
(18, 3),
(18, 4),
(18, 6),
(19, 1),
(19, 4);


-- ----------------------------------------

-- USER_WATCHLIST

CREATE TABLE user_watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_watchlist (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);
