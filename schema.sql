--
-- Table structure for table `tbl_groups`
--

CREATE TABLE IF NOT EXISTS `tbl_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_groups`
--

INSERT INTO `tbl_groups` (`id`, `name`) VALUES
(1, 'Group A'),
(2, 'Group B');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `tbl_users` (`id`, `group_id`, `username`, `password`, `fullname`, `created_on`, `updated_on`) VALUES
(1, 1, 'uname1', 'pasword1', 'foobar name', '2011-09-23 03:42:32', '0000-00-00 00:00:00'),
(2, 2, 'uname2', 'pasword2', 'name fool', '2011-09-23 03:42:32', '0000-00-00 00:00:00'),
(3, 1, 'uname3', 'pasword3', 'fool name', '2011-09-23 03:42:32', '0000-00-00 00:00:00'),
