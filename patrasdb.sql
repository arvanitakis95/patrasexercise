-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1:3306
-- Χρόνος δημιουργίας: 08 Σεπ 2022 στις 06:53:24
-- Έκδοση διακομιστή: 10.4.10-MariaDB
-- Έκδοση PHP: 8.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `patrasdb`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Basketball'),
(2, 'Football'),
(3, 'Εθνική Ελλάδος');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) NOT NULL,
  `author_name` varchar(50) NOT NULL,
  `post_text` text NOT NULL,
  `post_upvotes` int(5) NOT NULL DEFAULT 0,
  `post_downvotes` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `author_name`, `post_text`, `post_upvotes`, `post_downvotes`) VALUES
(1, 'Αντετοκούμπο: Θα το σηκώσουμε!', 'Κωνσταντίνο', 'Ο Γιάννης είναι σίγουρος ότι θα το σηκώσουμε!', 31, 15),
(9, 'Ο Ολυμπιακός γνωρίζει τον δρόμο για τη νίκη στη Γαλλία: Το πλάνο Κορμπεράν και ο αντι-Εμβιλά', 'Τσουκαλάς', 'Ο Ολυμπιακός έχει γυρίσει σελίδα, κάνει μια καινούργια αρχή με τον Κάρλος Κορμπεράν στον πάγκο του, έχει προσθέσει καινούργιους και σημαντικούς παίκτες στο ρόστερ του τις τελευταίες εβδομάδες, αλλά είναι εμφανές ότι θα χρειαστεί χρόνος μέχρι να «δέσει» η ομάδα και να βγάλει στο γήπεδο τις πραγματικές της δυνατότητες.\n\nΩστόσο, ο Ισπανός τεχνικός είναι αναγκασμένος και να δημιουργεί κάτι καλό μέσω των προπονήσεων και, ταυτόχρονα, να παίρνει τα αποτελέσματα που πρέπει, προκειμένου οι ερυθρόλευκοι να εκπληρώσουν τους στόχους τους.', 1, 2),
(10, 'Οι πρεμιέρες στη φάση των ομίλων', 'Marinakis', 'Οι πρεμιέρες στη φάση των ομίλων των ευρωπαϊκών διοργανώσεων κρύβουν πολλές φορές παγίδες και εκπλήξεις, ενώ είναι φανερό το άγχος των παικτών να μη γίνει κάποιο λάθος που θα στοιχίσει. Στο συγκεκριμένο παιχνίδι, ο Ολυμπιακός έχει τη δυνατότητα να κάνει το πρώτο βήμα για να έρθει πιο κοντά στον στόχο του που είναι η πρόκριση στην επόμενη φάση της διοργάνωσης.', 0, 2),
(11, 'wvrteby', 'avetse', 'bvaetav', 0, 0),
(12, '123', 'asFWEr', 'gtertgaer', 0, 1),
(13, '123', 'asFWEr', 'gtertgaer', 0, 0),
(14, 'ASDASD', 'ASDASD', 'ASDASD', 1, 1),
(15, 'WE', 'AWREG', 'EFGwe', 0, 1),
(16, 'Test', 'Test', 'adaerv', 1, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE IF NOT EXISTS `post_categories` (
  `post_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `post_categories`
--

INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(9, 2),
(10, 2),
(11, 3),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 2),
(14, 3),
(15, 2),
(15, 3),
(16, 2),
(16, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
