
CREATE TABLE `live_records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `live_records`
--

INSERT INTO `live_records` (`id`, `name`, `skills`, `address`, `designation`, `age`) VALUES
(1, 'Andrew', 'Java Script', 'London', 'Software Engineer', 44),
(2, 'Macmilan', 'PHP', 'London', 'Web Developer', 38),
(3, 'Philip', 'jQuery', 'New York', 'Web Developer', 40),
(4, 'Arnold', 'JavaScript', 'Delhi', 'Web Developer', 25),
(5, 'Shoib', 'NodeJS', 'India', 'Programmer', 35),
(6, 'Tim', 'Angular', 'London', 'Web Developer', 28),
(7, 'Turtle', 'MySQL', 'Paris', 'Web Developer', 26),
(8, 'David', 'HTML', 'Paris', 'Web Developer', 28),
(9, 'Ranson', 'jQuery', 'Sydney', 'Web Developer', 23),
(10, 'Nathan', 'PHP', 'London', 'Web Developer', 28),
(11, 'Andrew', 'PHP', 'Delhi', 'Web Developer', 38),
(12, 'Rosy', 'PHP', 'Delhi, India', 'Web Developer', 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `live_records`
--
ALTER TABLE `live_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `live_records`
--
ALTER TABLE `live_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

