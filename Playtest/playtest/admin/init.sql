SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- Supprimer d'éventuelles anciennes tables
DROP TABLE IF EXISTS `sae203_reviews`;
DROP TABLE IF EXISTS `sae203_notes`;
DROP TABLE IF EXISTS `sae203_jeux`;
DROP TABLE IF EXISTS `sae203_personnes`;

-- Création de la table des personnes
CREATE TABLE `sae203_personnes` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `prenom` varchar(100) NOT NULL,
                                    `nom` varchar(100) NOT NULL,
                                    `email` varchar(255) NOT NULL,
                                    `mot_de_passe` varchar(255) NOT NULL,
                                    `inscription` date DEFAULT NULL,
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des jeux
CREATE TABLE `sae203_jeux` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `personne` int(11) NOT NULL,
                               `titre` varchar(255) NOT NULL,
                               `description` text NOT NULL,
                               `creation` date DEFAULT NULL,
                               `lien_steam` varchar(255) NOT NULL,
                               `note` float NOT NULL,
                               `image_url` varchar(255) NOT NULL,
                               `image_details_url` varchar(255) NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `personne` (`personne`),
                               CONSTRAINT `sae203_jeux_ibfk_1` FOREIGN KEY (`personne`) REFERENCES `sae203_personnes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des notes
CREATE TABLE `sae203_notes` (
                                `personne` int(11) NOT NULL,
                                `jeux` int(11) NOT NULL,
                                `note` float NOT NULL,
                                KEY `personne` (`personne`),
                                KEY `jeux` (`jeux`),
                                CONSTRAINT `sae203_notes_ibfk_1` FOREIGN KEY (`personne`) REFERENCES `sae203_personnes` (`id`),
                                CONSTRAINT `sae203_notes_ibfk_2` FOREIGN KEY (`jeux`) REFERENCES `sae203_jeux` (`id`),
                                CONSTRAINT `CK_Note` CHECK (`note` >= 0 and `note` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des reviews
CREATE TABLE `sae203_reviews` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `personne` int(11) NOT NULL,
                                  `jeux` int(11) NOT NULL,
                                  `date` datetime NOT NULL,
                                  `commentaire` text NOT NULL,
                                  `reponse` int(11) DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `personne` (`personne`),
                                  KEY `jeux` (`jeux`),
                                  CONSTRAINT `sae203_reviews_ibfk_1` FOREIGN KEY (`personne`) REFERENCES `sae203_personnes` (`id`),
                                  CONSTRAINT `sae203_reviews_ibfk_2` FOREIGN KEY (`jeux`) REFERENCES `sae203_jeux` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET foreign_key_checks = 1;

-- Insertion dans la table des personnes
INSERT INTO `sae203_personnes` (prenom, nom, email, mot_de_passe, inscription) VALUES
                                                                                   ('Toby', 'Fox', 'tobyfox@undertale.com', 'chef', '2025-04-01'),
                                                                                   ('Local', 'Thunk', 'localthunk@balatro.com', 'chef', '2025-04-02'),
                                                                                   ('William', 'Pellen', 'william.pellen@hollowknight.com', 'chef', '2025-04-03'),
                                                                                   ('Hidetaka', 'Miyazaki', 'hidetaka.miyazaki@elden_ring.com', 'chef', '2025-05-03'),
                                                                                   ('Hidetako', 'Miyazako', 'hidetaka.miyazaki@ds.com', 'chef', '2025-05-03'),
                                                                                   ('David', 'Jaffe', 'david.jaffe@gow.com', 'chef', '2025-05-03'),
                                                                                   ('Meg', 'Thomas', 'meg.thomas@dbd.com', 'chef', '2025-05-03'),
                                                                                   ('Djibril', 'Lamroussi', 'djibril.lamroussi@dbd.com', 'chef', '2025-05-03'),
                                                                                   ('John', 'Doe', 'john.doe@dbd.com', 'chef', '2025-05-03'),
                                                                                   ('Toto', 'LeKing', 'toto.LeKing@dbd.com', 'chef', '2025-05-03'),
                                                                                   ('Ruppert', 'Grint', 'Ruppert.Grint@dbd.com', 'chef', '2025-05-03');


-- Insertion dans la table des jeux
INSERT INTO `sae203_jeux` (personne, titre, description, creation, lien_steam, note, image_url, image_details_url) VALUES
    (1, 'Undertale', 'Un jeu captivant qui repousse les limites de votre imagination.', '2025-04-10', 'https://store.steampowered.com/app/391540/Undertale/', 4.2, 'undertale.png', 'undertale_details.png'),
  (2, 'Balatro', 'Bien plus que les jeux de cartes traditionnelles, Balatro est un jeu de poker roguelike très très trèssss addictif.', '2025-04-11', 'https://store.steampowered.com/app/2379780/Balatro/', 4.1, 'balatro.png', 'balatro_details.png'),
  (3, 'Hollow Knight', 'Vivez une épopé folles dans Hollow Knight, le jeu qui vous fera vibrer.', '2025-05-11', 'https://store.steampowered.com/app/367520/Hollow_Knight/', 4.4, 'hollow_knight.png', 'hollow_knight_details.png'),
  (4, 'Silksong', 'Vivez une aventure incroyable dans Silksong, le jeu tant attendu.', '2025-07-11', 'https://store.steampowered.com/app/1030300/Hollow_Knight_Silksong/', 5.0, 'silksong.png', 'silksong_details.png'),
    (1, 'Elden Ring', 'Une aventure sans égale', '2025-07-11', 'https://store.steampowered.com/app/1245620/ELDEN_RING/', 5.0, 'elden_ring.png', 'elden_ring.png'),
    (1, 'Dark souls III', 'Le meilleur jeu de tous les temps, plongez dans un univers impitoyable.', '2025-07-11', 'https://store.steampowered.com/app/374320/DARK_SOULS_III/', 5.0, 'ds3.png', 'ds3_details.png'),
    (1, 'Sekiro : Shadows Die Twice', 'Le jeu de katana par exemple, entre combats ardu et destiné, vous serez servis.', '2025-07-11', 'https://store.steampowered.com/app/814380/Sekiro_Shadows_Die_Twice__GOTY_Edition/', 5.0, 'sekiro.png', 'sekiro_details.png'),
    (1, 'Celeste', 'Aidez Madeline à surmonter le mont Celeste', '2025-07-11', 'https://store.steampowered.com/app/504230/Celeste/', 5.0, 'celeste.png', 'celeste_details.png'),
    (1, 'Death Door', 'Un jeu indépendant ou on incarne un petit corbeau prêt a tout pour vaincre.', '2025-07-11', 'https://store.steampowered.com/app/894020/Deaths_Door/', 5.0, 'death_door.png', 'death_door_details.png'),
    (1, 'Resident evil 4', 'Le meilleur survival horror de la décennie', '2025-07-11', 'https://store.steampowered.com/app/2050650/Resident_Evil_4/', 5.0, 're4.png', 're4_details.png'),
    (1, 'Slay the Princess', 'Un visual novel étrange où il vous est demandé de tuer une pauvre princesse, y arriverez-vous ?', '2025-07-11', 'https://store.steampowered.com/app/1989270/Slay_the_Princess__The_Pristine_Cut/', 5.0, 'slay_the_princess.png', 'slay_the_princess_details.png'),
    (1, 'Street Fighter 2X', 'La réfèrence des jeux de combats', '2025-07-11', 'https://store.steampowered.com/app/1364780/Street_Fighter_6/', 5.0, 'sf2x.png', 'sf2x_details.png'),
    (1, 'God of War', 'Une histoire prenante et beaucoup de rebondissements, reprennez le contrôle du fameux Kratos dans ce jeu de 2018.', '2018-03-08', 'https://store.steampowered.com/app/1593500/God_of_War/', 5.0, 'gow.png', 'gow_details.png'),
    (1, 'Pokemon Saphir Alpha', 'Le pokémon DS dont vous ne serez pas décu', '2025-07-11', 'https://store.steampowered.com/app/1623730/Palworld/', 5.0, 'pokemon_sa.png', 'pokemon_sa_details.png'),
    (1, 'Pokemon Rubis Omega', 'Le pokémon DS dont vous ne serez pas décu', '2025-07-11', 'https://store.steampowered.com/app/1623730/Palworld/', 5.0, 'pokemon_ro.png', 'pokemon_ro_details.png'),
    (1, 'The Last Of Us part.1', 'Une histoire absolument dingue et des personnages attachant, ce jeu saura se faire aimer.', '2025-07-11', 'https://store.steampowered.com/app/1030300/Hollow_Knight_Silksong/', 5.0, 'the_last_of_us_part_1.png', 'the_last_of_us_part_1_details.png'),
    (1, 'The Last Of Us part.2', 'La suite du premier volet, en mieux.', '2025-07-11', 'https://store.steampowered.com/app/2531310/The_Last_of_Us_Part_II_Remastered/', 5.0, 'the_last_of_us_part_2.png', 'the_last_of_us_part_2_details.png');

-- Insertion dans la table des notes
INSERT INTO `sae203_notes` (personne, jeux, note) VALUES
  (1, 1, 4.5),
  (2, 1, 4.0),
  (1, 2, 3.5),
  (2, 2, 4.0);

-- Insertion dans la table des reviews
INSERT INTO `sae203_reviews` (personne, jeux, date, commentaire, reponse) VALUES
  (1, 1, '2025-04-12 10:00:00', 'Super jeu, fortement recommandé !', NULL),
  (2, 2, '2025-04-12 11:00:00', 'Aventure moyenne, quelques bugs.', NULL);
