DROP DATABASE BudgetMe;
CREATE DATABASE BudgetMe;
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
  `user_id` int
  (11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounts_users1_idx` (`user_id`),
  CONSTRAINT `fk_accounts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_budgets_users1_idx` (`user_id`),
  CONSTRAINT `fk_budgets_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `amount` double(11) NOT NULL,
  `merchant` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transactions_accounts_idx` (`account_id`),
  CONSTRAINT `fk_transactions_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



INSERT INTO users(`id`, `email`, `password`) VALUES (1, 'admin@usc.edu', '123456';

INSERT INTO accounts(name, user_id) VALUES('Credit Card', 1);
INSERT INTO accounts(name, user_id) VALUES('Amazon Money Card', 1);
INSERT INTO accounts(name, user_id) VALUES('EBT', 1);
INSERT INTO accounts(name, user_id) VALUES('Prepaid', 1);
INSERT INTO accounts(name, user_id) VALUES('Debit Card', 1);

INSERT INTO transactions(`category`, `amount`, `merchant`, `date`, `account_id`) 
VALUES(`Rent`, 30, `Landlord`, `03/28/2016`, 2);
INSERT INTO transactions(`category`, `amount`, `merchant`, `date`, `account_id`) 
VALUES(`Food`, 200, `Costco`, `03/26/2016`, 1);
INSERT INTO transactions(`category`, `amount`, `merchant`, `date`, `account_id`) 
VALUES(`Entertainment`, 80, `Landlord`, `04/01/2016`, 2);


