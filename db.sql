-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for v2
DROP DATABASE IF EXISTS `v2`;
CREATE DATABASE IF NOT EXISTS `v2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `v2`;


-- Dumping structure for table v2.account
DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `middile_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `mobile_no` int(20) NOT NULL,
  `alternate_no` int(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `designation_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `mobile` (`mobile_no`),
  UNIQUE KEY `alternative_number` (`alternate_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.bank_details
DROP TABLE IF EXISTS `bank_details`;
CREATE TABLE IF NOT EXISTS `bank_details` (
  `bank_id` int(10) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `ifsc_code` varchar(15) NOT NULL,
  `is_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.labour
DROP TABLE IF EXISTS `labour`;
CREATE TABLE IF NOT EXISTS `labour` (
  `labour_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile_no` int(20) NOT NULL,
  `alternate_no` int(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bank_id` varchar(100) NOT NULL,
  `type` enum('Intern','Outern') DEFAULT NULL,
  PRIMARY KEY (`labour_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.labour_attendence
DROP TABLE IF EXISTS `labour_attendence`;
CREATE TABLE IF NOT EXISTS `labour_attendence` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `labour_id` int(10) NOT NULL,
  `no_of_worker` int(10) NOT NULL,
  `no_of_mazons` int(10) NOT NULL,
  `ot_mazons` int(10) NOT NULL,
  `ot_mazon_hrs` int(10) NOT NULL,
  `ot_workers` int(10) NOT NULL,
  `ot_workers_hrs` int(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_labour_attendence_labour` (`labour_id`),
  CONSTRAINT `FK_labour_attendence_labour` FOREIGN KEY (`labour_id`) REFERENCES `labour` (`labour_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.labour_cost
DROP TABLE IF EXISTS `labour_cost`;
CREATE TABLE IF NOT EXISTS `labour_cost` (
  `id` int(10) NOT NULL,
  `labour_id` int(10) DEFAULT NULL,
  `cost` int(10) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__labour` (`labour_id`),
  CONSTRAINT `FK__labour` FOREIGN KEY (`labour_id`) REFERENCES `labour` (`labour_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.material
DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `unit` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.material_purchased
DROP TABLE IF EXISTS `material_purchased`;
CREATE TABLE IF NOT EXISTS `material_purchased` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `material_id` int(10) DEFAULT NULL,
  `supplier_id` int(10) DEFAULT NULL,
  `invoice_no` int(10) DEFAULT NULL,
  `invoice_bill_location` varchar(255) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `vehicle_no` int(10) DEFAULT NULL,
  `delivered_by` varchar(50) DEFAULT NULL,
  `recieved_by` varchar(50) DEFAULT NULL,
  `bill_no` int(10) DEFAULT NULL,
  `date_time` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `purchased_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_material_purchased_material` (`material_id`),
  KEY `FK_material_purchased_account` (`purchased_by`),
  CONSTRAINT `FK_material_purchased_account` FOREIGN KEY (`purchased_by`) REFERENCES `account` (`account_id`),
  CONSTRAINT `FK_material_purchased_material` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.payment
DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(10) NOT NULL,
  `bank_id` int(10) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `mode` enum('NEFT','CHEQUE','CASH','CHECQUE','DD') NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `FK__bank_details` (`bank_id`),
  KEY `FK_payment_supplier` (`supplier_id`),
  CONSTRAINT `FK_payment_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  CONSTRAINT `FK__bank_details` FOREIGN KEY (`bank_id`) REFERENCES `bank_details` (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.petty_cash
DROP TABLE IF EXISTS `petty_cash`;
CREATE TABLE IF NOT EXISTS `petty_cash` (
  `id` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `account_id` int(10) DEFAULT NULL,
  `amt` int(10) DEFAULT NULL,
  `date_time` timestamp NULL DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `given_by` int(10) DEFAULT NULL,
  `approved_by` int(10) DEFAULT NULL,
  KEY `FK__project` (`project_id`),
  KEY `FK_petty_cash_account` (`account_id`),
  KEY `FK_petty_cash_account_2` (`given_by`),
  KEY `FK_petty_cash_account_3` (`approved_by`),
  CONSTRAINT `FK_petty_cash_account_2` FOREIGN KEY (`given_by`) REFERENCES `account` (`account_id`),
  CONSTRAINT `FK_petty_cash_account_3` FOREIGN KEY (`approved_by`) REFERENCES `account` (`account_id`),
  CONSTRAINT `FK_petty_cash_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`),
  CONSTRAINT `FK__project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.petty_cash_purchase
DROP TABLE IF EXISTS `petty_cash_purchase`;
CREATE TABLE IF NOT EXISTS `petty_cash_purchase` (
  `id` int(10) NOT NULL,
  `material_id` int(10) NOT NULL,
  `amt` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__material` (`material_id`),
  CONSTRAINT `FK__material` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.project
DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.supplier
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile_no` int(20) NOT NULL,
  `alternate_no` int(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bank_id` varchar(100) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_account` (`account_id`),
  CONSTRAINT `FK_user_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.vehicle
DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` char(50) NOT NULL,
  `vehicle_no` varchar(10) NOT NULL,
  `owner_name` char(50) NOT NULL,
  `owner_no` int(10) NOT NULL,
  `driver_name` char(50) NOT NULL,
  `driver_no` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.vehicle_attendance
DROP TABLE IF EXISTS `vehicle_attendance`;
CREATE TABLE IF NOT EXISTS `vehicle_attendance` (
  `id` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `ot_hrs` int(10) DEFAULT NULL,
  `vehicle_cost_id` int(10) DEFAULT NULL,
  `date_time` timestamp NULL DEFAULT NULL,
  KEY `FK_vehicle_attendance_project` (`project_id`),
  CONSTRAINT `FK_vehicle_attendance_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table v2.vehicle_cost
DROP TABLE IF EXISTS `vehicle_cost`;
CREATE TABLE IF NOT EXISTS `vehicle_cost` (
  `id` int(10) NOT NULL,
  `vehicle_id` int(10) DEFAULT NULL,
  `cost` int(10) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_cost_vehicle` (`vehicle_id`),
  CONSTRAINT `FK_vehicle_cost_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
