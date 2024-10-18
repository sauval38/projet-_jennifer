-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 oct. 2024 à 18:41
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `maison_hemera`
--

-- --------------------------------------------------------

--
-- Structure de la table `about_me`
--

CREATE TABLE `about_me` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `archived_order`
--

CREATE TABLE `archived_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `archive_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `billing_address`
--

CREATE TABLE `billing_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_amount`, `created_at`, `updated_at`) VALUES
(2, 5, 1620.00, '2024-10-09 14:40:35', '2024-10-18 14:00:27');

-- --------------------------------------------------------

--
-- Structure de la table `cart_detail`
--

CREATE TABLE `cart_detail` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_option_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `cart_detail`
--

INSERT INTO `cart_detail` (`id`, `cart_id`, `product_id`, `product_option_id`, `quantity`, `price`) VALUES
(2, 2, 3, 117, 10, 60.00),
(3, 2, 3, 119, 14, 60.00),
(4, 2, 3, 118, 2, 60.00),
(6, 2, 3, 116, 1, 60.00);

--
-- Déclencheurs `cart_detail`
--
DELIMITER $$
CREATE TRIGGER `trg_update_user_cart_amount` AFTER INSERT ON `cart_detail` FOR EACH ROW BEGIN
    UPDATE cart
    SET total_amount = (
        SELECT COALESCE(SUM(price * quantity), 0)
        FROM cart_detail
        WHERE cart_id = NEW.cart_id
    )
    WHERE id = NEW.cart_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_user_cart_amount_delete` AFTER DELETE ON `cart_detail` FOR EACH ROW BEGIN
    UPDATE cart
    SET total_amount = (
        SELECT COALESCE(SUM(price * quantity), 0)
        FROM cart_detail
        WHERE cart_id = OLD.cart_id
    )
    WHERE id = OLD.cart_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_user_cart_amount_update` AFTER UPDATE ON `cart_detail` FOR EACH ROW BEGIN
    UPDATE cart
    SET total_amount = (
        SELECT COALESCE(SUM(price * quantity), 0)
        FROM cart_detail
        WHERE cart_id = NEW.cart_id
    )
    WHERE id = NEW.cart_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `colors`
--

INSERT INTO `colors` (`id`, `name`) VALUES
(3, 'noir'),
(4, 'rouge'),
(5, 'blanc'),
(6, 'rose');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `lastname`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Blasco', 'jenniferblasco230389@hotmail.com', 'qvrevq', 'vzvzq', '2024-10-03 20:17:18'),
(2, 'ace', 'acw@acw.fr', 'albert', 'charles', '2024-10-09 15:39:11');

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `delivery_option_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `delivery_address`
--

INSERT INTO `delivery_address` (`id`, `user_id`, `address_1`, `address_2`, `country`, `city`, `postal_code`) VALUES
(1, 5, '78 rue de la fontaine', 'les trous', 'Suisse', 'Lyon', '65870');

-- --------------------------------------------------------

--
-- Structure de la table `delivery_option`
--

CREATE TABLE `delivery_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `delivery_option`
--

INSERT INTO `delivery_option` (`id`, `name`, `description`, `price`) VALUES
(1, 'Standard', 'Livraison en 3 à 5 jours ouvrés', 4.99),
(2, 'Express', 'Livraison en 24 à 48 heures', 9.99),
(3, 'Retrait en magasin', 'Retirez votre commande dans le magasin le plus proche', 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_option_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `method_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_name`, `method_details`) VALUES
(1, 'Carte Bancaire', 'Visa, MasterCard, American Express acceptés'),
(2, 'PayPal', 'Payez avec votre compte PayPal en toute sécurité'),
(3, 'Virement Bancaire', 'Effectuez un virement directement depuis votre banque');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_range_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `product_range_id`, `name`, `description`, `price`, `stock`, `height`, `weight`, `created_at`, `updated_at`) VALUES
(3, 9, 'zaeaz', 'eazeazeaze eazezaea azea ea eaze aeazzeae', 60.00, 4, 32.00, 45.00, '2024-09-19 14:50:16', '2024-09-19 14:50:16'),
(4, 9, 'zaeaz', 'eazeazeaze eazezaea azea ea eaze aeazzeae', 60.00, 4, 32.00, 45.00, '2024-09-19 14:52:54', '2024-09-19 14:52:54'),
(5, 10, 'azeaze', 'eaze eaz eeaze aeaaze', 20.00, 2, 15.00, 12.00, '2024-09-19 15:02:34', '2024-09-19 15:02:34');

-- --------------------------------------------------------

--
-- Structure de la table `products_range`
--

CREATE TABLE `products_range` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `products_range`
--

INSERT INTO `products_range` (`id`, `name`, `description`, `image_path`) VALUES
(9, 'Gamme Boudoir', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/_GMA3182-min.jpg'),
(10, 'Gamme Dream', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/DSC02766-Enhanced-NR.jpg'),
(11, 'Gamme Enigma', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/IMG20221025181912.jpg'),
(12, 'Gamme Érécta ', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/DSC02933.jpg'),
(13, 'Gamme Fémina', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/DSC02928-2.jpg'),
(14, 'Gamme nomade', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/DSC02806.jpg'),
(15, 'Gamme Tendre', 'Découvre l’univers sensuel et féminin de la Collection Boudoir de Maison Héméra', 'assets/images/gammes/DSC02981.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `product_option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `product_option_id`) VALUES
(25, 5, 'assets/images/products/240_F_448691502_K9eKcz0cc9zExrr9sjPtq9p4z3F2NySZ.jpg', 103),
(26, 5, 'assets/images/products/hugo.jpg', 104),
(27, 5, 'assets/images/products/nargacuga.png', 105),
(33, 3, 'assets/images/products/alatreon.png', 116),
(34, 3, 'assets/images/products/rathalos.png', 117),
(35, 3, 'assets/images/products/rathian.png', 118),
(36, 4, 'assets/images/products/alatreon.png', 80),
(37, 4, 'assets/images/products/rajang.png', 80),
(38, 4, 'assets/images/products/rathalos.png', 81),
(44, 3, 'assets/images/products/rajang.png', 119);

-- --------------------------------------------------------

--
-- Structure de la table `product_option`
--

CREATE TABLE `product_option` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `product_option`
--

INSERT INTO `product_option` (`id`, `product_id`, `option_name`, `option_value`) VALUES
(80, 4, 'couleur', 'rouge'),
(81, 4, 'couleur', 'rose'),
(103, 5, 'couleur', 'noir'),
(104, 5, 'couleur', 'rouge'),
(105, 5, 'couleur', 'rose'),
(116, 3, 'couleur', 'noir'),
(117, 3, 'couleur', 'rouge'),
(118, 3, 'couleur', 'blanc'),
(119, 3, 'couleur', 'rose');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'USER'),
(2, 'ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `social_network`
--

CREATE TABLE `social_network` (
  `id` int(11) NOT NULL,
  `network_name` varchar(255) NOT NULL,
  `network_url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT 0,
  `token` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `lastname`, `firstname`, `email`, `password`, `phone_number`, `is_verified`, `token`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', NULL, NULL, 'user@user.fr', '$2y$10$w1E/iATu59hK/3JD60wZdevXAUkURjwgA7yyqlYm6U5TiEhUQBk4u', NULL, 0, '', '2024-09-04 15:02:17', '2024-09-05 11:56:27'),
(3, 2, 'charles', NULL, NULL, 'boubou601@live.fr', '$2y$10$CQQ6yhrG/g04016ZU.OjtOoTYSiHHH6LkCdMr9WJ3Ui5xO.NPjFVS', NULL, 0, 'f42bd435a550cee45ac8869ef8cb097424a21a4a7186fbb96f7f6b8b8657fbeb72ce2cf35c0244fccf5ef374b8c9f8828034', '2024-09-04 15:05:32', '2024-09-06 14:50:13'),
(4, 2, 'jennifer', NULL, NULL, 'jenniferblasco230389@hotmail.com', '$2y$10$EDzkqVXLGVGBnhDHjsZRXerEORyi9iIUVSBynySHt4XVWjERT0LsC', NULL, 0, '', '2024-09-04 15:46:42', '2024-09-05 11:56:34'),
(5, 2, 'ace', 'GAYARD', 'Louis', 'ace@ace.fr', '$2y$10$qeeCpnaeX3L4PQlHc5t.KuQor.VFZPWRFsQ1Q.q6rfF/wC6x8U3V.', NULL, 0, NULL, '2024-09-05 15:11:41', '2024-10-18 14:46:00'),
(11, 1, 'lyon', NULL, NULL, 'lyon@hotmail.de', '$2y$10$ShmgviURUXd5iwD6zTuym.FyaxItdbdybGO9mwMFjxEjYJ8EqWh9e', NULL, 1, NULL, '2024-09-06 15:09:29', '2024-09-06 15:09:46');

-- --------------------------------------------------------

--
-- Structure de la table `wish_list`
--

CREATE TABLE `wish_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_option_id` int(11) DEFAULT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `about_me`
--
ALTER TABLE `about_me`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `archived_order`
--
ALTER TABLE `archived_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_archived` (`order_id`);

--
-- Index pour la table `billing_address`
--
ALTER TABLE `billing_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_billing_address` (`user_id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_cart` (`user_id`);

--
-- Index pour la table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_cart_detail` (`cart_id`),
  ADD KEY `fk_product_cart_detail` (`product_id`),
  ADD KEY `fk_product_option_cart_detail` (`product_option_id`);

--
-- Index pour la table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_delivery` (`order_id`),
  ADD KEY `fk_delivery_option` (`delivery_option_id`);

--
-- Index pour la table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_delivery_address` (`user_id`);

--
-- Index pour la table `delivery_option`
--
ALTER TABLE `delivery_option`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_order` (`user_id`),
  ADD KEY `fk_payment_order` (`payment_method_id`);

--
-- Index pour la table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_order_detail` (`order_id`),
  ADD KEY `fk_product_order_detail` (`product_id`),
  ADD KEY `fk_product_option_order_detail` (`product_option_id`);

--
-- Index pour la table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_range` (`product_range_id`);

--
-- Index pour la table `products_range`
--
ALTER TABLE `products_range`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_option_id` (`product_option_id`);

--
-- Index pour la table `product_option`
--
ALTER TABLE `product_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_option` (`product_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `social_network`
--
ALTER TABLE `social_network`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_role_user` (`role_id`);

--
-- Index pour la table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_wishlist` (`user_id`),
  ADD KEY `fk_product_wishlist` (`product_id`),
  ADD KEY `fk_product_option_wishlist` (`product_option_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `about_me`
--
ALTER TABLE `about_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `archived_order`
--
ALTER TABLE `archived_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `billing_address`
--
ALTER TABLE `billing_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cart_detail`
--
ALTER TABLE `cart_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `delivery_option`
--
ALTER TABLE `delivery_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `products_range`
--
ALTER TABLE `products_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `product_option`
--
ALTER TABLE `product_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archived_order`
--
ALTER TABLE `archived_order`
  ADD CONSTRAINT `fk_order_archived` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `billing_address`
--
ALTER TABLE `billing_address`
  ADD CONSTRAINT `fk_user_billing_address` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_user_cart` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD CONSTRAINT `fk_cart_cart_detail` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `fk_product_cart_detail` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_product_option_cart_detail` FOREIGN KEY (`product_option_id`) REFERENCES `product_option` (`id`);

--
-- Contraintes pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `fk_delivery_option` FOREIGN KEY (`delivery_option_id`) REFERENCES `delivery_option` (`id`),
  ADD CONSTRAINT `fk_order_delivery` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD CONSTRAINT `fk_user_delivery_address` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_order_detail` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `fk_product_option_order_detail` FOREIGN KEY (`product_option_id`) REFERENCES `product_option` (`id`),
  ADD CONSTRAINT `fk_product_order_detail` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_range` FOREIGN KEY (`product_range_id`) REFERENCES `products_range` (`id`);

--
-- Contraintes pour la table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product_option`
--
ALTER TABLE `product_option`
  ADD CONSTRAINT `fk_product_option` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_user` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Contraintes pour la table `wish_list`
--
ALTER TABLE `wish_list`
  ADD CONSTRAINT `fk_product_option_wishlist` FOREIGN KEY (`product_option_id`) REFERENCES `product_option` (`id`),
  ADD CONSTRAINT `fk_product_wishlist` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_user_wishlist` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
