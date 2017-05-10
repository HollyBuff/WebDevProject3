--
-- Database: `webdev_project2`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_name` varchar(300) NOT NULL,
  `product_model` varchar(150) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_Image` blob NOT NULL,
  `product_inStock` int(5) NOT NULL,
  `product_reviews` text,
  `product_rate` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_history`
--

CREATE TABLE `purchased_history` (
  `customer_Id` varchar(24) NOT NULL,
  `product_id` varchar(24) NOT NULL,
  `purchased_quality` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchased_history`
--

INSERT INTO `purchased_history` (`customer_Id`, `product_id`, `purchased_quality`) VALUES
('StevenQin', 'D003', 4),
('StevenQin', 'D007', 1),
('StevenQin', 'D005', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `User_Email` varchar(30) NOT NULL,
  `User_Name` varchar(24) NOT NULL,
  `User_Password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`User_Email`, `User_Name`, `User_Password`) VALUES
('1002101429@qq.com', 'StevenQin', 'Baby2135'),
('123@acu.edu', 'Justin123', 'Asdasd123'),
('982@yahoo.com', 'love123', 'Ab123456'),
('sls12@acu.edu', 'Jo4422', 'Asdasd123'),
('1423@qq.com', 'StevenQin2', 'Baby2135'),
('dw@acu.edu', 'emily', 'Baby2135'),
('', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
