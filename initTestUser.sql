DROP DATABASE IF EXISTS `BudgetMe`;
CREATE DATABASE `BudgetMe`;
USE BudgetMe;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
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



INSERT INTO `users`(`id`, `email`, `password`) VALUES (1, 'admin@usc.edu', '123456');

INSERT INTO `accounts` VALUES
(1, 'Credit Card', 1),
(2, 'Amazon Money Card', 1),
(3, 'EBT', 1),
(4, 'Prepaid', 1),
(5, 'Debit Card', 1);

INSERT INTO `transactions` VALUES
(1, 'Rent', 30.21, 'Landlord', '03/28/2016', 2),
(2, 'Food', 200.54, 'Costco', '03/26/2016', 1),
(3, 'Other', 80.11, 'Landlord', '04/01/2016', 2);

INSERT INTO `budgets` VALUES
(1, 'Food', 0, 1),
(2, 'Rent', 0, 1),
(3, 'Loans', 0, 1),
(4, 'Bills', 0, 1),
(5, 'Other', 0, 1);

INSERT INTO `users`(`id`, `email`, `password`) VALUES (2, 'guest@usc.edu', '123456');

INSERT INTO `accounts` VALUES
(6, 'Credit Card2', 2),
(7, 'Amazon Money Card2', 2),
(8, 'EBT2', 2),
(9, 'Prepaid2', 2),
(10, 'Debit Card2', 2);

INSERT INTO `transactions` VALUES
(4, 'Rent', 30.21, 'Landlord', '03/28/2016', 7),
(5, 'Food', 200.54, 'Costco', '03/26/2016', 6),
(6, 'Entertainment', 80.11, 'Landlord', '04/01/2016', 7);

INSERT INTO `budgets` VALUES
(6, 'Food', 0, 2),
(7, 'Rent', 0, 2),
(8, 'Loans', 0, 2),
(9, 'Bills', 0, 2),
(10, 'Other', 0, 2);

INSERT INTO `users`(`id`, `email`, `password`) VALUES (3, 'admin2@usc.edu', '123456');

INSERT INTO `transactions` VALUES
(7, 'Other', -123.23, 'Landlord', '03/28/2016', 3),
(8, 'Bills', -500.00, 'Costco', '03/26/2016', 3),
(9, 'Loans', -50.11, 'Landlord', '04/01/2016', 3),
(10, 'Rent', -1020.57, 'Landlord', '04/01/2016', 3),
(11, 'Food', -200.00, 'Landlord', '04/01/2016', 3);


INSERT INTO `users`(`id`, `email`, `password`) VALUES (4, 'budgetSpentTester@usc.edu', '123456');

INSERT INTO `accounts` VALUES
(11, 'Credit Card', 4),
(12, 'Savings', 4),
(13, 'Checking', 4);

INSERT INTO `transactions` VALUES
(12, 'Rent', 5.00, 'Landlord', '03/28/2016', 11),
(13, 'Rent', 12.00, 'Costco', '03/26/2016', 12),
(14, 'Rent', 10.00, 'Costco', '03/26/2015', 13),
(15, 'Other', 7.00, 'Expo', '03/26/2016', 12),
(16, 'Other', 15.10, 'Times', '03/26/2016', 11),
(17, 'Other', 12.00, 'Target', '03/23/2016', 12),
(18, 'Bills', 13.54, 'Water', '03/27/2016', 13),
(19, 'Loans', 100.00, 'Bank of America', '03/22/2016', 11),
(20, 'Loans', 200.00, 'Chase', '03/21/2016', 12),
(21, 'Food', 150.20, 'Pizza', '03/22/2016', 13),
(22, 'Food', 1.25, 'Ramen', '03/25/2016', 13);

INSERT INTO `budgets` VALUES
(11, 'Food', 300, 4),
(12, 'Rent', 500, 4),
(13, 'Loans', 12, 4),
(14, 'Bills', 50, 4),
(15, 'Other', 5, 4);



