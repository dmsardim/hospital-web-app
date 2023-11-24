
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Database: `patientdb`
--
CREATE DATABASE hospitaldb;

USE hospitaldb;


CREATE TABLE `patients` (
  `id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `religion` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `nik` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `patients` (`id`, `name`, `sex`, `phone`, `religion`, `address`, `nik`) VALUES
(1, 'Dimas', 'Male', 081456725786, 'Islam', 'Jakarta', 123456),
(2, 'Ardi', 'Male', 081325934798, 'Islam', 'Bogor', 7891011);


ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `patients`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
  
COMMIT;
