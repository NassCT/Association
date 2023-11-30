SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `activite` (
  `id_act` int(11) NOT NULL AUTO_INCREMENT,
  `nom_act` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `num_resp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_act`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `avoir` (
  `id_act` int(11) NOT NULL,
  `id_creneau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `creneau` (
  `id_creneau` int(11) NOT NULL,
  `heure_debut` datetime DEFAULT NULL,
  `heure_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `participant` (
  `num_participant` int(11) NOT NULL,
  `nom_participant` varchar(100) DEFAULT NULL,
  `prenom_participant` varchar(100) DEFAULT NULL,
  `mail_participant` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `participation` (
  `id_part` int(11) NOT NULL,
  `id_act` int(11) NOT NULL,
  `num_participant` int(11) NOT NULL,
  `id_creneau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `responsable` (
  `num_resp` int(11) NOT NULL AUTO_INCREMENT,
  `nom_resp` varchar(100) DEFAULT NULL,
  `prenom_resp` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`num_resp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `activite` (`id_act`, `nom_act`, `site`, `num_resp`) VALUES
(1, 'Airsoft', 'Forêt interdite', 3),
(2, 'Cours de danse', 'Jungle Amazonienne', 1),
(3, 'Hockey sur glace', 'Dunes Saharienne', 2),
(4, 'Paintball', 'Corée du nord', 3),
(5, 'Urbex', 'Andalousie', 0),
(6, 'Chasse aux zombies', 'Treyarch', 4);

INSERT INTO `avoir` (`id_act`, `id_creneau`) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO `creneau` (`id_creneau`, `heure_debut`, `heure_fin`) VALUES
(1, '2023-09-07 10:00:00', '2023-09-07 12:00:00'),
(2, '2023-09-07 14:00:00', '2023-09-07 16:00:00'),
(3, '2023-09-08 11:00:00', '2023-09-08 13:00:00');

INSERT INTO `participant` (`num_participant`, `nom_participant`, `prenom_participant`, `mail_participant`) VALUES
(1, 'Smith', 'Alice', 'alice.smith@example.com'),
(2, 'Dubois', 'Pierre', 'pierre.dubois@example.com'),
(3, 'Gonzalez', 'Maria', 'maria.gonzalez@example.com'),
(4, 'Gruere', 'Anthony', 'gruere.anthony@example.com');

INSERT INTO `participation` (`id_part`, `id_act`, `num_participant`, `id_creneau`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 1, 2, 1);

INSERT INTO `responsable` (`num_resp`, `nom_resp`, `prenom_resp`) VALUES
(1, 'Jhon', 'Wick'),
(2, 'Dupont', 'Jean'),
(3, 'Nail', "M'haar"),
(4, 'Arnlod', 'Swartzy'),
(5, 'Teddy', 'Bear');

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `role`, `email`) VALUES
(1, 'admin', 'admin', 'administrations', 'admin@association.com'),
(2, 'service', 'service', 'inscriptions', 'service@association.com');

ALTER TABLE `activite`
  ADD UNIQUE (`id_act`);

ALTER TABLE `avoir`
  ADD PRIMARY KEY (`id_act`,`id_creneau`),
  ADD KEY `id_creneau` (`id_creneau`);

ALTER TABLE `creneau`
  ADD PRIMARY KEY (`id_creneau`);

ALTER TABLE `participant`
  ADD PRIMARY KEY (`num_participant`);

ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_part`),
  ADD KEY `id_act` (`id_act`),
  ADD KEY `num_participant` (`num_participant`),
  ADD KEY `id_creneau` (`id_creneau`);

ALTER TABLE `activite`
  MODIFY `id_act` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `creneau`
  MODIFY `id_creneau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `participant`
  MODIFY `num_participant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `participation`
  MODIFY `id_part` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `responsable`
  MODIFY `num_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
