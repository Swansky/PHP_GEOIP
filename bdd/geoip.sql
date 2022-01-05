CREATE TABLE `geoip` (
  `ip_from` int NOT NULL,
  `ip_to` int NOT NULL,
  `country_code` char(2) NOT NULL,
  `country_name` varchar(64) NOT NULL,
  `region_name` varchar(128) NOT NULL,
  `city_name` varchar(128) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
