CREATE TABLE `carts` (
  `book_ID` int(11) NOT NULL,
  `book_name` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `image_filename` varchar(256) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
