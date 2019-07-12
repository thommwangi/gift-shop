-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2019 at 01:39 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giftit`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `Id` int(11) NOT NULL,
  `Brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`Id`, `Brand`) VALUES
(1, 'Rampsons');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(255) NOT NULL,
  `Id` int(255) NOT NULL,
  `p_id` int(255) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(255) NOT NULL,
  `CategoryName` varchar(255) NOT NULL,
  `Parent` int(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `CategoryName`, `Parent`) VALUES
(1, 'Relationship', 0),
(2, 'Occassion', 0),
(3, 'Categories', 0),
(7, 'Him', 1),
(8, 'Her', 1),
(9, 'Teen', 1),
(10, 'Baby', 1),
(27, 'Birthday', 2),
(28, 'Christmas', 2),
(29, 'Anniversary', 2),
(30, 'Wedding', 2),
(31, 'Women\'s Fashion', 3),
(32, 'Men\'s Fashion', 3),
(33, 'Sports', 3),
(34, 'Gadgets', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `trx_id` varchar(255) NOT NULL,
  `p_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `quantity`, `trx_id`, `p_status`) VALUES
(8, 3, 1, 1, '1RA76126607639737', 'Completed'),
(9, 3, 1, 1, '1PG759010B0997417', 'Completed'),
(10, 3, 2, 1, '1PG759010B0997417', 'Completed'),
(11, 3, 1, 1, '2VE514809K0571200', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`) VALUES
(5, 'thomas.mwangi@strathmore.edu', '0cca6f6cea8cfeafafa587d204d92c8ce31e16471e3a7de0915a092b560d975d14c3b039bd6bdcc0c6a375579eb547bdf302'),
(6, 'thomas.mwangi@strathmore.edu', 'dc57d6aa436daa673bccc4e0930178ac472e9c92c6275e1e10dde7111cce29ec7da086671db134d6b103b588650fd76ac208'),
(7, 'thomas.mwangi@strathmore.edu', '41753aabfe8bec8dc9500d810b5055119de54bf34b44e9b42969848f0a47e1ccab6999689c81e64a75f8e42fbbce8ccc9af4');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `DiscountedPrice` double NOT NULL,
  `OriginalPrice` double NOT NULL,
  `Brand` int(11) NOT NULL,
  `Category` int(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Feature` tinyint(4) NOT NULL DEFAULT '0',
  `Size` text NOT NULL,
  `deleted` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Id`, `Title`, `DiscountedPrice`, `OriginalPrice`, `Brand`, `Category`, `Image`, `Description`, `Feature`, `Size`, `deleted`) VALUES
(1, 'Friendly Character Bowl', 1200, 1600, 1, 7, '\\GIFT-SHOP\\images\\bowl1.jpg', 'A Personal Creations Exclusive! Perfect for cereal, ice cream or soup!\r\n							Made of porcelain.\r\n							Holds 32 oz.\r\n							Microwave safe.\r\n							Hand wash.\r\n							Choose any characters and we’ll add any message on 2 lines, up to 10 characters per line.\r\n							Icon options range from grandma, grandpa, mom, dad, teen boy, teen girl, kid boy, kid girl, toddler boy, toddler girl, baby boy, baby girl, cat and dog.\r\n							We also offer your choice of ethnicity (Caucasian, African American or Hispanic), hair color (red, brown, black, blond, or bald), and pet color (yellow, black, brown, gray or white).', 1, 'Small:5 , Medium:6, Large:8', 0),
(2, 'MLB cufflings', 900, 1200, 1, 7, '/GIFT-SHOP/images/cuff1.jpg', '<p>What\'s a true football fan wear to a formal occasion? He\'s sure to score mega fashion points decked out in cuff links featuring his favorite NFL team’s logo. It’s a fun way to show his team pride while adding some gridiron glamour to any dressy outfit.\r\nSilverstone plated base metal and enamel with bullet back closure.\r\nMeasures approx. 3/4\" sq.\r\nOfficially licensed by the National Football League.\r\nPresented in Official NFL gift packaging with turf interior.', 1, 'Small:12, Medium:13', 0),
(3, 'Womens Plush Robe', 2000, 2400, 1, 8, '/GIFT-SHOP/images/robe1.jpg', 'Wrap yourself in decadence, this Turkish robe is as luxurious as those offered at five-star hotels. Soft and inviting, the plush, thirsty fabric acts like a high-quality towel, making it perfect for après bath, hot tub or shower. Transform your home into a villa of the highest extravagance. Exclusively from RedEnvelope.\r\nMade of plush polyester micro-fiber.\r\nMid-calf length.\r\nMachine wash warm with like colors, gentle cycle, only non-chlorine bleach when needed. Tumble dry low.\r\nWomen\'s sizes S/M (2-6), M/L (8-14).\r\nAvailable in blush robe with gray or cream thread or white robe with gray or sea blue thread.\r\nChoose script or serif font.\r\nPersonalize with any name up to 9 characters or any single initial.', 1, 'S/M:8,M/L:12', 0),
(4, 'Embelished purse Mirror', 800, 1200, 1, 8, '/GIFT-SHOP/images/mirror1.jpg', 'To keep her looking good, why not provide her with a handy and equally good-looking mirror? Ours is embellished with an intricate filigree-inspired design on both front and back.\r\nBrushed-nickel plate (silver color finish).\r\nFeatures two mirrors: one regular and one 2x magnified.\r\nUpgrade to personalized and add any message up to 10 characters.', 1, '', 0),
(6, 'Embrossed Charging Dock', 2400, 2700, 1, 9, '/GIFT-SHOP/images/charger1.jpg', 'Keep everyday essentials stylishly organized with this contemporary, multi-function docking station. With a perch for your phone, keychain notch, slot for watches or bracelets and groove along the bottom for charging cords, your nightstand or office desk will stay pleasantly clutter-free.\r\nSleek white lacquer finish with a golden rebar accent bar.\r\nMeasures 8-1/4”Lx8-1/4”Wx9-1/2” H, fully assembled.\r\nWipe clean with a soft cloth.\r\nEmboss with any name up to 10 characters in gold.', 1, '', 0),
(7, 'Picnic bagpack', 2400, 2700, 1, 7, '/GIFT-SHOP/images/bag1.jpg', 'Hosting a family picnic is as simple as filling our backpack with the family\'s favorite foods. The canvas pack is already loaded up with melamine plates, goblets, flatware and napkins for four, plus a bread knife, wooden cutting board, salt and pepper shakers and a sommelier\'s corkscrew. It even has a detachable wine cooler and sable-gray felt blanket.\r\nPadded shoulder straps for comfort.\r\nInsulated main compartment keeps food cold.\r\nMeasures 18\"Lx7\"Wx16\"H.\r\nBlanket measures 47-1/4\"L x 53\"W.\r\nPersonalized with any message up to 15 characters.', 1, 'Small:12;Medium:12,Large:4', 0),
(8, 'Any message glass block', 1800, 2300, 1, 8, '/GIFT-SHOP/images/block1.jpg', 'Proclaim your own personal message on our beautiful glass block! It makes a perfect and artful gift for that special someone!\r\nMade of glass.\r\nMeasures 5\"Wx4\"Hx3/4\"D.\r\nLaser engraved with any 3-6 line message up to 22 characters.', 1, 'Small:12,Medium:23,Large:13', 0),
(9, 'Reasons I love you stones', 900, 1200, 1, 8, '/GIFT-SHOP/images/stones1.jpg', 'These stones aren’t for skipping, but they’re sure to make your loved one’s heart skip a beat. That’s because they feature 9 of the many reasons you adore them, etched in stone. Think of all the ways you could use them to send your heartfelt message.\r\nNine brushed-nickel “stones”.\r\nComes in a faux-suede bag that can be personalized with 2 initials on a small metal plaque.\r\n\"+\" will always appear\r\nStones measure approx. 1-3/8\"L.\r\nStones read “I love you…” on the front, and a different “reasons” on the back: “for always getting my jokes”; “because you\'re an inspiration”; “because you are so much fun”; “because of your great smile”; “for being so giving”; “because I just do!”; “because you love me”; “because you rock”; “for your honesty”.', 1, '', 0),
(10, 'Baby Elephant Ring holder', 1900, 1200, 1, 9, '/GIFT-SHOP/images/ringholder1.jpg', 'They say an elephant never forgets which makes this diminutive silver-plated version a logical partner for helping her remember where she put her rings. The artfully designed elephant makes a delightful addition to her bathroom sink or bedside table. Engraved up to 9 characters. Exclusively from RedEnvelope.\r\nMade of polished silver plate.\r\nElephant\'s upturned trunk is also a symbol of good-luck.\r\nElephant\'s upturned trunk and tray base hold her rings safely and securely.\r\nUpgrade to personalized and add a name up to 9 characters.', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_tag_value`
--

CREATE TABLE `product_tag_value` (
  `id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `tag_type_value_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_tag_value`
--

INSERT INTO `product_tag_value` (`id`, `product_id`, `tag_type_value_id`) VALUES
(1, 3, 17),
(2, 3, 1),
(3, 3, 15),
(4, 3, 7),
(5, 3, 6),
(6, 3, 8),
(7, 3, 3),
(8, 3, 5),
(9, 3, 14),
(10, 1, 2),
(11, 1, 4),
(12, 1, 7),
(13, 1, 16),
(14, 1, 15),
(15, 1, 8),
(16, 2, 2),
(17, 2, 4),
(18, 2, 16),
(19, 2, 9),
(20, 2, 15),
(21, 2, 8),
(22, 2, 16),
(23, 2, 4),
(24, 4, 4),
(25, 4, 3),
(26, 4, 5),
(27, 4, 6),
(28, 4, 7),
(29, 4, 9),
(30, 4, 10),
(31, 4, 11),
(32, 4, 14),
(33, 4, 16),
(34, 4, 17),
(35, 5, 1),
(36, 5, 5),
(37, 5, 7),
(38, 5, 9),
(39, 5, 8),
(40, 5, 11),
(41, 5, 13),
(42, 5, 16),
(43, 5, 17),
(44, 6, 2),
(45, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `paddress` varchar(255) NOT NULL,
  `PhoneNumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `email`, `password`, `gender`, `fullname`, `address`, `paddress`, `PhoneNumber`) VALUES
(3, 'rosanneodiero9@gmail.com', 'Icarly415', 'Female', 'Rosanne Odiero', 'p.o.box 5678 Nairobi', 'Mandera', 727890045),
(48, 'mwangi@gmail.com', '$2y$10$8pj9rj2EkIFDnO9F4J7RdeQIJUytv/4MjyM64JIKsYU8KnBmGi0wG', 'Male', 'thomas mwangi k', 'p.o.box 123434', 'Siwaka', 719198278),
(51, 'lucianne@gmail.com', '$2y$10$aFDoioa1RK1T0g2Y2cViQeDVQvwXpR5E07lhY86NPV5F/In0w7gYe', 'Female', 'Lucianne Odiero', 'p.o.box 123456 ', 'NAIROBI', 718277654),
(54, 'rosanne@gmail.com', '$2y$10$vhpbRL39eSLuXz2ozm/kCeTe29jDj1RDRwmAz78FvfTmZm6hmL9vq', 'Female', 'Rosanne', 'p.o.box 103294', 'Nairobi', 719194390),
(56, 'rosanneodiero@gmail.com', '$2y$10$ZTnWllMddnrcX.Wkgph/C.UVutwo3.L8ERvnPyr5OqZ.V1vDfoUaW', 'Female', 'Rosanne Ogwel', 'P.O.Box 123400', 'Nairobi', 719194390),
(58, 'rmuthoni@gmail.com', '$2y$10$HnP1T6ri56y6s0PQDHIe1uoiFBtJF2N6rHV6GqL2AYh5tg9IJYJPq', 'Female', 'Rose Muthoni', 'p.o.box 102383', 'Nairobi', 710102983),
(62, 'rosanne@gmail.com', 'qwerty76', 'Female', 'rosanne', 'Nairobi', 'Nairobi', 719199286),
(63, 'rosanne@gmail.com', 'qwerty76', 'Female', 'rosanne', 'Nairobi', 'Nairobi', 719199286),
(64, 'thom@strathmore.edu', 'froyo95*', 'Male', 'tom', '17126', 'school', 711448404),
(65, 'thom\r\n@strathmore.edu', 'froyo95*', 'Male', 'tom', '17126', 'school', 711448404),
(66, 'msuya@gmail.com', '$2y$10$SeHUPNkXkqwWytzhxNHUAOHajXlKFvFF1D4UfBQPohpmJhCRcJtFm', 'Female', 'msuya', '123', '1234', 12345),
(67, 'msuya@gmail.com', '$2y$10$MJO2girv1mdgAFbql7HK1eO24HLetk18/3mDvrw7SU4jXyjQG.9j.', 'Female', 'msuya', '123', '1234', 12345),
(68, 'ule@gmail.com', '$2y$10$sqDNjvPvk4.hGM6EuNUml.qTxaWLkYphjsbobVKM8qkgm6TXO4rC6', 'Other', 'ule', '123', '1234', 123),
(69, 'ule@gmail.com', '$2y$10$qKvu2cF/sZ.elm/VQLdWPeBvyiY8tNYGhQ0VcqoXNG10mjT2sRKAm', 'Other', 'ule', '123', '1234', 123),
(70, 'mum@gmail.com', '$2y$10$Cb8wD9M8e/jSHfUQzeO2iezq04ZU1xznCSOqtgDWos7.TsOi5mKCy', 'Female', 'mum', '234', '1234', 12345),
(71, 'mum@gmail.com', '$2y$10$FZOXIOM8Oc09mhyWwrXKzOP7kok73tCsYeEIxNmdw7YW8Fk5CA.IC', 'Female', 'mum', '234', '1234', 12345),
(72, 'ma@gmail.com', '$2y$10$RD9/EwxnV3VKS1VMRvSlTeT1XM4n/So/xFCB2CwkQWFfhU4V8P2YK', 'Female', 'ma', '123', '1234', 12345),
(73, 'ma@gmail.com', '$2y$10$KTfP0V9xmToSkHtXXrmUQOwOelUuQyc3TQJZ20aJGk.HyDkWA2EY2', 'Female', 'ma', '123', '1234', 12345),
(74, 'tho@strathmore.edu', '$2y$10$DRTaO9ISCUnTgUT7MERtfOgdqIyOjY3ofSJ8oEz5//vnpuPPnoP/m', 'Male', 'mwas', '123', '1234', 12345),
(75, 'thongi@strathmore.edu', '$2y$10$OwGisgzgvl6KAEdY.tqeMOJD/I00v3livBY.IiPSD4YsCQAs4n7L2', 'Male', 'mwas', '123', '1234', 12345),
(76, 'tom@gmail.com', '$2y$10$bT9f45HAWs97E2AiWk6Rj.M.s8bZi7hRrwdVEzyOUOTzPDcWDmk1S', 'Male', 'ya', '123', '1234', 12345),
(77, 'tom@gmail.com', '$2y$10$HpRjb.zdTQA9OQtuMh0idOUihDSQBaFjbzGEK38OaRtJFqHqgZJFO', 'Male', 'ya', '123', '1234', 12345),
(78, 'thomas.mwangi@strathmore.edu', '$2y$10$d6jieMGen4HGCuaf8yccwO9Byp/6MwHvyk71/aTJTo0mPGTrXJCIC', 'Male', 'tomasi', '123', '1234', 12345),
(79, 'thomas.mwangi@strathmore.edu', '$2y$10$uXFzi.8J5Oy8gsLIos7Pl.9ca/vVVpqxKt6QnkN3gqtFt5mhwX8Mq', 'Male', 'tomasi', '123', '1234', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `tag_type`
--

CREATE TABLE `tag_type` (
  `tag_type_id` int(255) NOT NULL,
  `tag_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_type`
--

INSERT INTO `tag_type` (`tag_type_id`, `tag_type`) VALUES
(1, 'Relationship'),
(2, 'Occassion'),
(3, 'Age'),
(4, 'Gender');

-- --------------------------------------------------------

--
-- Table structure for table `tag_type_value`
--

CREATE TABLE `tag_type_value` (
  `id` int(255) NOT NULL,
  `tag_type_id` int(255) NOT NULL,
  `tag_type_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_type_value`
--

INSERT INTO `tag_type_value` (`id`, `tag_type_id`, `tag_type_value`) VALUES
(1, 1, 'Mother'),
(2, 1, 'Father'),
(3, 1, 'Sister'),
(4, 1, 'Brother'),
(5, 1, 'Friend'),
(6, 2, 'Wedding'),
(7, 2, 'Birthday'),
(8, 2, 'Christmas'),
(9, 2, 'Anniversary'),
(10, 3, '0-9'),
(11, 3, '10-15'),
(12, 3, '16-20'),
(13, 3, '21-30'),
(14, 3, '31-30'),
(15, 3, '31-50'),
(16, 4, 'Male'),
(17, 4, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'thomas mwangi', 'thomasmwangi96@gmail.com', '$2y$10$SnkoNLcWoxCZ4WQwif5e/OhcD4FuWWUgdXy6iH4ltURM5Ig7g.IZO', '2018-10-09 23:09:00', '2019-07-09 13:01:44', 'editor,admin'),
(4, 'rosanne odiero', 'rose@gmail.com', '$2y$10$SnkoNLcWoxCZ4WQwif5e/OhcD4FuWWUgdXy6iH4ltURM5Ig7g.IZO', '2018-10-15 12:20:36', '2018-10-15 11:43:08', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Brand` (`Brand`),
  ADD KEY `Category` (`Category`);

--
-- Indexes for table `product_tag_value`
--
ALTER TABLE `product_tag_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_type_value_id` (`tag_type_value_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tag_type`
--
ALTER TABLE `tag_type`
  ADD PRIMARY KEY (`tag_type_id`);

--
-- Indexes for table `tag_type_value`
--
ALTER TABLE `tag_type_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_type_id` (`tag_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_tag_value`
--
ALTER TABLE `product_tag_value`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tag_type`
--
ALTER TABLE `tag_type`
  MODIFY `tag_type_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag_type_value`
--
ALTER TABLE `tag_type_value`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `products` (`Id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`Id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Brand`) REFERENCES `brand` (`Id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`Category`) REFERENCES `categories` (`Id`);

--
-- Constraints for table `product_tag_value`
--
ALTER TABLE `product_tag_value`
  ADD CONSTRAINT `product_tag_value_ibfk_1` FOREIGN KEY (`tag_type_value_id`) REFERENCES `tag_type_value` (`id`);

--
-- Constraints for table `tag_type_value`
--
ALTER TABLE `tag_type_value`
  ADD CONSTRAINT `tag_type_value_ibfk_1` FOREIGN KEY (`tag_type_id`) REFERENCES `tag_type` (`tag_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
