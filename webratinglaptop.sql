-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 04:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webratinglaptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `total_harga` int(25) NOT NULL,
  `tanggal_checkout` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_checkout`
--

CREATE TABLE `detail_checkout` (
  `id` int(11) NOT NULL,
  `checkout_id` int(11) NOT NULL,
  `laptop_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_satuan` int(25) NOT NULL,
  `total_harga` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `laptop_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `laptop_id`, `pengguna_id`, `tanggal`) VALUES
(1, 6, 2, '2024-04-04 02:17:16'),
(5, 5, 2, '2024-04-04 02:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `laptop`
--

CREATE TABLE `laptop` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `spesifikasi` text NOT NULL,
  `harga` int(25) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptop`
--

INSERT INTO `laptop` (`id`, `nama`, `merek`, `spesifikasi`, `harga`, `gambar`) VALUES
(3, 'Vivobook 14 (A1402, 12th Gen Intel) Ram 8GB', 'Asus', 'ASUS Vivobook 14 A1402ZA-IPS752 - Terra Cotta\r\n\r\n• Processor : Intel® Core™ i7-1260P Processor 2.1 GHz (18M Cache, up to 4.7 GHz, 4P+8E cores)\r\n• Memory : 8GB /16GB DDR4 3200\r\n• Storage : 512GB M.2 NVMe™ PCIe® 3.0 SSD\r\n• Intergrated GPU : Intel® UHD Graphics\r\n• Display : 14.0-inch FHD (1920 x 1080) 16:9 aspect ratio IPS-level Panel, Brightness : 250nits, 45% NTSC color gamut, Anti-glare display\r\n• OS : Windows 11 Home\r\n• Front-facing camera : 720p HD camera With privacy shutter\r\n• Wireless : Wi-Fi 6(802.11ax) (Dual band) 2*2 + Bluetooth 5\r\n• Sensors : FingerPrint', 10978000, 'w800.png'),
(4, 'Latitude 5430 Intel Core i5-1235U', 'Dell', 'Spesifikasi :\r\n•NB DELL LAT 5430 BACKPACK ESSENTIAL\r\n•i5-1245U , 16GB, 512GB SSD, WIN11PRO, 3YR\r\n\r\nDell Latitude 5430\r\n•Intel Core i5-1245U 12th Gen\r\n•Memory 16GB DDR4\r\n•Storage 512GB M.2 SSD PCIe NVMe\r\n•VGA Intel Iris Xe Graphics\r\n•Display 14\" FHD (1920x1080) Anti-Glare\r\n•Wi-Fi 6 + Bluetooth 5.1\r\n•3 Cell 41Whr ExpressCharge,Fingerprint, Backlit Keyboard\r\n•OS : Windows 10 Professional 64 Bit / Free Upgrade Ke Windows 11 Professional\r\n•Warranty Warranty 3Yr Onsite Service + Accidental Damage Service Protection\r\n•GARANSI RESMI DELL 3 TAHUN\r\n( PROSES CLAIM GARANSI DI BANTU )', 19600000, 'dell.jpg'),
(5, 'Nitro V 15 (ANV15-51)', 'Acer', 'Beyond Fast GeForce RTX™ 40 Series Laptop\r\nNVIDIA DLSS 3, Ultra efficient Ada Lovelace Arch, and Full Ray Tracing\r\n\r\nNitro V 15 (ANV15-51-5115)\r\nGraphics : NVIDIA GeForce RTX 4050 with 6GB of GDDR6\r\nProcessor : Intel Core i5-13420H processor (12MB cache, up to 4.60Ghz)\r\nOS : Windows 11 Home\r\nMemory : 1*8GB DDR5\r\nStorage : 512GB SSD NVMe\r\nInch, Res, Ratio, Panel : 15.6\" FHD LED IPS 144Hz', 14999000, 'acer anv15-51.jpg'),
(6, 'VICTUS GAMING 16 E1091AX RYZEN 7 6800H 16GB', 'HP', 'Spesifikasi ;\r\n- Processor: AMD Ryzen 7 6800H (up to 4.7 GHz max boost clock, 16 MB L3 cache, 8 cores, 16 threads)\r\nMemory : 16 GB / 32 GB DDR4-3200 MHz RAM (2 x 8 GB)\r\nStorage : 512 GB PCIe NVMe TLC M.2 SSD\r\nDisplay : 16.1\" diagonal, FHD (1920 x 1080), 144 Hz 45%NTSC\r\nOperating system : Windows 11 Home 64\r\nGraphics : NVIDIA GeForce RTX 3050 Laptop GPU 4GB\r\nKeyboard Backlite English\r\nPorts :\r\n1 SuperSpeed USB Type-C 5Gbps signaling rate (DisplayPort 1.4, HP Sleep and Charge);\r\n1 SuperSpeed USB Type-A 5Gbps signaling rate (HP Sleep and Charge);\r\n2 SuperSpeed USB Type-A 5Gbps signaling rate;\r\n1 HDMI 2.1;\r\n1 RJ-45;\r\n1 AC smart pin;\r\n1 headphone/microphone combo', 14499000, 'hp victus.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `no_telepon`, `email`, `password`, `alamat`, `role`) VALUES
(1, 'Admin', '082157545379', 'admin@email.com', '$2y$10$D.edAvtj/doq.vZVp36fi.uhcdPMxF0mfDM8sYY9UNRhTenlqBOTi', '-', 'admin'),
(2, 'Nazwa', '082157545379', 'nazwaa@email.com', '$2y$10$ymVxVeJcFKfnWZh77.pz7OJmBmacyTIUsWIpGqghNf.T4AdRo.JzW', 'Jl. Cendrawasih', 'user'),
(3, 'Amanda', '087654328976', 'amanda@email.com', '$2y$10$wkAo/hqX7dDQIEccDs7xRuvG1/uQoNMfFyNcw0ZfMmji6S2fQ/iva', 'Jl. Parahyangan', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `laptop_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `review` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `laptop_id`, `pengguna_id`, `rating`, `review`, `tanggal`) VALUES
(1, 6, 2, 5, 'Laptop gaming mantapp, performa kencangg', '2024-04-03 18:43:47'),
(2, 6, 3, 4.9, 'Sangat baguss', '2024-04-04 02:28:54'),
(3, 5, 3, 4.7, 'Langsung di pake ngedit dan rendering', '2024-04-04 02:32:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indexes for table `detail_checkout`
--
ALTER TABLE `detail_checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkout_id` (`checkout_id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- Indexes for table `laptop`
--
ALTER TABLE `laptop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_checkout`
--
ALTER TABLE `detail_checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laptop`
--
ALTER TABLE `laptop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `detail_checkout`
--
ALTER TABLE `detail_checkout`
  ADD CONSTRAINT `detail_checkout_ibfk_1` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`id`),
  ADD CONSTRAINT `detail_checkout_ibfk_2` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
