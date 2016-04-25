DROP DATABASE IF EXISTS `BudgetMe`;
CREATE DATABASE `BudgetMe`;
USE BudgetMe;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounts_users1_idx` (`user_id`),
  CONSTRAINT `fk_accounts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `amount` float(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_budgets_users1_idx` (`user_id`),
  CONSTRAINT `fk_budgets_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `amount` float(11) NOT NULL,
  `merchant` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transactions_accounts_idx` (`account_id`),
  CONSTRAINT `fk_transactions_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


INSERT INTO `users`(`id`, `email`, `password`, `salt`) VALUES (1, 'admin@usc.edu', '2E8053F788FAA26A4515F99B4D1DFCB01CEF12AF127524C192D61AF3DAB55E38', 'dccbb06ca68d5017c443e914d4ebb96eb36a1cb6576e');

INSERT INTO `accounts` VALUES
(1, 'Credit Card', 1),
(2, 'Amazon Money Card', 1),
(3, 'EBT', 1),
(4, 'Prepaid', 1),
(5, 'Debit Card', 1);

INSERT INTO `transactions` VALUES
(1, 'Deposit', 300.21, 'Landlord', '03/28/2016', 2),
(2, 'Food', -200.54, 'Costco', '03/26/2016', 1),
(3, 'Other', -80.11, 'Landlord', '04/01/2016', 2);

INSERT INTO `budgets` VALUES
(1, 'Food', 0, 1, 'February'),
(2, 'Rent', 0, 1, 'February'),
(3, 'Loans', 0, 1, 'February'),
(4, 'Bills', 0, 1, 'February'),
(5, 'Other', 0, 1, 'February');

INSERT INTO `users`(`id`, `email`, `password`, `salt`) VALUES (2, 'guest@usc.edu', 'A2D8A1452A900A8E724371F9C86CE7BB81D0368D061050381AC0F583D69120F8', '0159b5d3cadb594f9f95a114c3874f5dd43d78531265');

INSERT INTO `accounts` VALUES
(6, 'Credit Card2', 2),
(7, 'Amazon Money Card', 2),
(8, 'EBT2', 2),
(9, 'Prepaid2', 2),
(10, 'Debit Card2', 2);

INSERT INTO `transactions` VALUES
(4, 'Deposit', 500.21, 'Landlord', '03/28/2016', 7),
(5, 'Food', -200.54, 'Costco', '03/26/2016', 6),
(6, 'Rent', -80.11, 'Landlord', '04/01/2016', 7);

INSERT INTO `budgets` VALUES
(6, 'Food', 0, 2, 'February'),
(7, 'Rent', 0, 2, 'February'),
(8, 'Loans', 0, 2, 'February'),
(9, 'Bills', 0, 2, 'February'),
(10, 'Other', 0, 2, 'February');

INSERT INTO `users`(`id`, `email`, `password`, `salt`) VALUES (3, 'admin2@usc.edu', '969CC5F5E5B831FFB98A2F7759D8D880BC99CD7FE8D7586687F09645937F7CA6', '0e80852da55fe2a1e246b9a4e8cd5f08223fe41915f9');

INSERT INTO `transactions` VALUES
(7, 'Deposit', 123.23, 'Landlord', '03/28/2016', 3),
(8, 'Bills', -500.00, 'Costco', '03/26/2016', 3),
(9, 'Loans', -50.11, 'Landlord', '04/01/2016', 3),
(10, 'Rent', -1020.57, 'Landlord', '04/01/2016', 3),
(11, 'Food', -200.00, 'Landlord', '04/01/2016', 3);


INSERT INTO `users`(`id`, `email`, `password`, `salt`) VALUES (4, 'budgetSpentTester@usc.edu', '87017137305455935E266BBCC157286C9F1A9F3F1F93B90C557DE433EB4B4A2E', '4caac23abdacd0fe9ef696d2eeb17efe954199d79811');

INSERT INTO `accounts` VALUES
(11, 'Credit Card', 4),
(12, 'Savings', 4),
(13, 'Checking', 4);

INSERT INTO `transactions` VALUES
(12, 'Rent', -5.00, 'Landlord', '03/28/2016', 11),
(13, 'Rent', -12.00, 'Costco', '03/26/2016', 12),
(14, 'Rent', -10.00, 'Costco', '03/26/2015', 13),
(15, 'Other', -7.00, 'Expo', '03/26/2016', 12),
(16, 'Other', -15.10, 'Times', '03/26/2016', 11),
(17, 'Other', -12.00, 'Target', '03/23/2016', 12),
(18, 'Bills', -13.54, 'Water', '03/27/2016', 13),
(19, 'Loans', -100.00, 'Bank of America', '03/22/2016', 11),
(20, 'Loans', -200.00, 'Chase', '03/21/2016', 12),
(21, 'Food', -150.20, 'Pizza', '03/22/2016', 13),
(22, 'Food', -1.25, 'Ramen', '03/25/2016', 13);

INSERT INTO `budgets` VALUES
(11, 'Food', 0, 4, 'February'),
(12, 'Rent', 0, 4, 'February'),
(13, 'Loans', 0, 4, 'February'),
(14, 'Bills', 0, 4, 'February'),
(15, 'Other', 0, 4, 'February'),
(16, 'Food', 0, 1, 'March'),
(17, 'Rent', 0, 1, 'March'),
(18, 'Loans', 0, 1, 'March'),
(19, 'Bills', 0, 1, 'March'),
(20, 'Other', 0, 1, 'March'),
(21, 'Food', 0, 2, 'March'),
(22, 'Rent', 0, 2, 'March'),
(23, 'Loans', 0, 2, 'March'),
(24, 'Bills', 0, 2, 'March'),
(25, 'Other', 0, 2, 'March'),
(26, 'Food', 0, 4, 'March'),
(27, 'Rent', 0, 4, 'March'),
(28, 'Loans', 0, 4, 'March'),
(29, 'Bills', 0, 4, 'March'),
(30, 'Other', 0, 4, 'March'),
(31, 'Food', 0, 1, 'April'),
(32, 'Rent', 0, 1, 'April'),
(33, 'Loans', 0, 1, 'April'),
(34, 'Bills', 0, 1, 'April'),
(35, 'Other', 0, 1, 'April'),
(36, 'Food', 0, 2, 'April'),
(37, 'Rent', 0, 2, 'April'),
(38, 'Loans', 0, 2, 'April'),
(39, 'Bills', 0, 2, 'April'),
(40, 'Other', 0, 2, 'April'),
(41, 'Food', 300, 4, 'April'),
(42, 'Rent', 500, 4, 'April'),
(43, 'Loans', 12, 4, 'April'),
(44, 'Bills', 50, 4, 'April'),
(45, 'Other', 5, 4, 'April');

INSERT INTO `budgets` VALUES
(46, 'Food', 0, 2, 'January'),
(47, 'Rent', 0, 2, 'January'),
(48, 'Loans', 0, 2, 'January'),
(49, 'Bills', 0, 2, 'January'),
(50, 'Other', 0, 2, 'January'),
(51, 'Food', 0, 2, 'May'),
(52, 'Rent', 0, 2, 'May'),
(53, 'Loans', 0, 2, 'May'),
(54, 'Bills', 0, 2, 'May'),
(55, 'Other', 0, 2, 'May'),
(56, 'Food', 0, 2, 'June'),
(57, 'Rent', 0, 2, 'June'),
(58, 'Loans', 0, 2, 'June'),
(59, 'Bills', 0, 2, 'June'),
(60, 'Other', 0, 2, 'June'),
(61, 'Food', 0, 2, 'July'),
(62, 'Rent', 0, 2, 'July'),
(63, 'Loans', 0, 2, 'July'),
(64, 'Bills', 0, 2, 'July'),
(65, 'Other', 0, 2, 'July'),
(66, 'Food', 0, 2, 'August'),
(67, 'Rent', 0, 2, 'August'),
(68, 'Loans', 0, 2, 'August'),
(69, 'Bills', 0, 2, 'August'),
(70, 'Other', 0, 2, 'August'),
(71, 'Food', 0, 2, 'September'),
(72, 'Rent', 0, 2, 'September'),
(73, 'Loans', 0, 2, 'September'),
(74, 'Bills', 0, 2, 'September'),
(75, 'Other', 0, 2, 'September'),
(76, 'Food', 0, 2, 'October'),
(77, 'Rent', 0, 2, 'October'),
(78, 'Loans', 0, 2, 'October'),
(79, 'Bills', 0, 2, 'October'),
(80, 'Other', 0, 2, 'October'),
(81, 'Food', 0, 2, 'November'),
(82, 'Rent', 0, 2, 'November'),
(83, 'Loans', 0, 2, 'November'),
(84, 'Bills', 0, 2, 'November'),
(85, 'Other', 0, 2, 'November'),
(86, 'Food', 0, 2, 'December'),
(87, 'Rent', 0, 2, 'December'),
(88, 'Loans', 0, 2, 'December'),
(89, 'Bills', 0, 2, 'December'),
(90, 'Other', 0, 2, 'December'),
(91, 'Food', 0, 1, 'January'),
(92, 'Rent', 0, 1, 'January'),
(93, 'Loans', 0, 1, 'January'),
(94, 'Bills', 0, 1, 'January'),
(95, 'Other', 0, 1, 'January'),
(96, 'Food', 0, 1, 'May'),
(97, 'Rent', 0, 1, 'May'),
(98, 'Loans', 0, 1, 'May'),
(99, 'Bills', 0, 1, 'May'),
(100, 'Other', 0, 1, 'May'),
(101, 'Food', 0, 1, 'June'),
(102, 'Rent', 0, 1, 'June'),
(103, 'Loans', 0, 1, 'June'),
(104, 'Bills', 0, 1, 'June'),
(105, 'Other', 0, 1, 'June'),
(106, 'Food', 0, 1, 'July'),
(107, 'Rent', 0, 1, 'July'),
(108, 'Loans', 0, 1, 'July'),
(109, 'Bills', 0, 1, 'July'),
(110, 'Other', 0, 1, 'July'),
(111, 'Food', 0, 1, 'August'),
(112, 'Rent', 0, 1, 'August'),
(113, 'Loans', 0, 1, 'August'),
(114, 'Bills', 0, 1, 'August'),
(115, 'Other', 0, 1, 'August'),
(116, 'Food', 0, 1, 'September'),
(117, 'Rent', 0, 1, 'September'),
(118, 'Loans', 0, 1, 'September'),
(119, 'Bills', 0, 1, 'September'),
(120, 'Other', 0, 1, 'September'),
(121, 'Food', 0, 1, 'October'),
(122, 'Rent', 0, 1, 'October'),
(123, 'Loans', 0, 1, 'October'),
(124, 'Bills', 0, 1, 'October'),
(125, 'Other', 0, 1, 'October'),
(126, 'Food', 0, 1, 'November'),
(127, 'Rent', 0, 1, 'November'),
(128, 'Loans', 0, 1, 'November'),
(129, 'Bills', 0, 1, 'November'),
(130, 'Other', 0, 1, 'November'),
(131, 'Food', 0, 1, 'December'),
(132, 'Rent', 0, 1, 'December'),
(133, 'Loans', 0, 1, 'December'),
(134, 'Bills', 0, 1, 'December'),
(135, 'Other', 0, 1, 'December');







