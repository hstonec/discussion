--
-- Dumping data for table `t_user`
--

INSERT INTO `t_department` (`id_department`, `id_parent`, `department_name`) VALUES
(2, 1, 'Stevens IT'),
(3, 1, 'New York University'),
(4, 1, 'Columbia University'),
(5, 1, 'CUNY Baruch College'),
(26, 2, 'Computer Science'),
(27, 2, 'Electronic Engineering'),
(28, 2, 'Financial Engineering'),
(29, 2, 'Chemistry Engineering'),
(30, 3, 'History'),
(31, 3, 'Music'),
(32, 3, 'Spanish'),
(33, 4, 'Geology'),
(34, 4, 'Construction'),
(35, 4, 'Building Design'),
(36, 5, 'Business Management'),
(37, 5, 'Human Resource'),
(38, 5, 'Economics'),
(39, 5, 'Accounting'),
(40, 26, '2014 Fall CS'),
(41, 26, '2014 Spring CS'),
(42, 27, '2014 Fall EE'),
(43, 27, '2014 Spring EE'),
(44, 28, '2014 Fall FE'),
(45, 28, '2014 Spring FE'),
(46, 29, '2014 Fall CE'),
(47, 29, '2014 Spring CE'),
(48, 30, '2014 Fall HI'),
(49, 30, '2014 Spring HI'),
(50, 31, '2014 Fall MU'),
(51, 31, '2014 Spring MU'),
(52, 32, '2014 Fall SP'),
(53, 32, '2014 Spring SP'),
(54, 33, '2014 Fall GE'),
(55, 33, '2014 Spring GE'),
(56, 34, '2014 Fall CO'),
(57, 34, '2014 Spring CO'),
(58, 35, '2014 Fall BD'),
(59, 35, '2014 Spring BD'),
(60, 36, '2014 Fall BM'),
(61, 36, '2014 Spring BM'),
(62, 37, '2014 Fall HR'),
(63, 37, '2014 Spring HR'),
(64, 38, '2014 Fall EO'),
(65, 38, '2014 Spring EO'),
(66, 39, '2014 Fall AC'),
(67, 39, '2014 Spring AC');


INSERT INTO `t_user` (`id_user`, `id_role`, `id_department`, `username`, `password`, `first_name`, `last_name`, `gender`, `photo_url`) VALUES
(2, 1, 1, 'rootroot2', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'rootfirstname', 'rootlastname', 2, 'photo/default.png'),
(3, 2, 2, 'stevens', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'stevensfn', 'stevensln', 1, 'photo/default.png'),
(4, 2, 3, 'newyork', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'newyorkfn', 'newyorkln', 2, 'photo/default.png'),
(5, 2, 4, 'columbia', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'columbiafn', 'columbialn', 1, 'photo/default.png'),
(6, 2, 5, 'cunybaruch', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'cunyfn', 'cunyln', 1, 'photo/default.png'),
(7, 3, 26, 'stevenscs', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'stevenscsfn', 'stevensln', 1, 'photo/default.png'),
(8, 3, 27, 'stevensee', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'stevenseefn', 'stevensln', 1, 'photo/default.png'),
(9, 3, 28, 'stevensfe', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'stevensfefn', 'stevensfeln', 1, 'photo/default.png'),
(10, 3, 29, 'stevensce', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'stevenscefn', 'stevensceln', 1, 'photo/default.png'),
(11, 3, 30, 'newyorkhi', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'newyorkhifn', 'newyorkhiln', 1, 'photo/default.png'),
(12, 3, 31, 'newyorkmu', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'newyorkmufn', 'newyorkmuln', 1, 'photo/default.png'),
(13, 3, 32, 'newyorksp', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'newyorkspfn', 'newyorkspln', 1, 'photo/default.png'),
(14, 3, 33, 'columbiage', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'columbiagefn', 'columbiageln', 1, 'photo/default.png'),
(15, 3, 34, 'columbiaco', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'columbiacofn', 'columbiacoln', 1, 'photo/default.png'),
(16, 3, 35, 'columbiabd', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'columbiabdfn', 'columbiabdfn', 1, 'photo/default.png'),
(17, 3, 36, 'cunybm', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'cunybmfn', 'cunybmln', 1, 'photo/default.png'),
(18, 3, 37, 'cunyhr', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'cunyhrfn', 'cunyhrln', 1, 'photo/default.png'),
(19, 3, 38, 'cunyec', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'cunyecfn', 'cunyecln', 2, 'photo/default.png'),
(20, 3, 39, 'cunyac', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'cunyacfn', 'cunyacln', 1, 'photo/default.png'),
(21, 3, 40, '2014fcs', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fcs', '2014fcs', 1, 'photo/default.png'),
(22, 3, 41, '2014scs', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014scs', '2014scs', 1, 'photo/default.png'),
(23, 3, 42, '2014fee', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fee', '2014fee', 1, 'photo/default.png'),
(24, 3, 43, '2014see', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014see', '2014see', 1, 'photo/default.png'),
(25, 3, 44, '2014ffe', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014ffe', '2014ffe', 1, 'photo/default.png'),
(26, 3, 45, '2014sfe', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sfe', '2014sfe', 2, 'photo/default.png'),
(27, 3, 46, '2014fce', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fce', '2014fce', 1, 'photo/default.png'),
(28, 3, 47, '2014sce', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sce', '2014sce', 2, 'photo/default.png'),
(29, 3, 48, '2014fhi', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fhi', '2014fhi', 1, 'photo/default.png'),
(30, 3, 49, '2014shi', '2014shia$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014shi', '2014shi', 1, 'photo/default.png'),
(31, 3, 50, '2014fmu', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fmu', '2014fmu', 2, 'photo/default.png'),
(32, 3, 51, '2014smu', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014smu', '2014smu', 1, 'photo/default.png'),
(33, 3, 52, '2014fsp', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fsp', '2014fsp', 2, 'photo/default.png'),
(34, 3, 53, '2014ssp', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014ssp', '2014ssp', 1, 'photo/default.png'),
(35, 3, 54, '2014fge', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fge', '2014fge', 1, 'photo/default.png'),
(36, 3, 55, '2014sge', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sge', '2014sge', 1, 'photo/default.png'),
(37, 3, 56, '2014fco', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fco', '2014fco', 2, 'photo/default.png'),
(38, 3, 57, '2014sco', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sco', '2014sco', 2, 'photo/default.png'),
(39, 3, 58, '2014fbd', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fbd', '2014fbd', 1, 'photo/default.png'),
(40, 3, 59, '2014sbd', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sbd', '2014sbd', 1, 'photo/default.png'),
(41, 3, 60, '2014fbm', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fbm', '2014fbm', 1, 'photo/default.png'),
(42, 3, 61, '2014sbm', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sbm', '2014sbm', 2, 'photo/default.png'),
(43, 3, 62, '2014fhr', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fhr', '2014fhr', 1, 'photo/default.png'),
(44, 3, 63, '2014shr', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014shr', '2014shr', 2, 'photo/default.png'),
(45, 3, 64, '2014feo', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014feo', '2014feo', 2, 'photo/default.png'),
(46, 3, 65, '2014seo', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014seo', '2014seo', 1, 'photo/default.png'),
(47, 3, 66, '2014fac', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014fac', '2014fac', 1, 'photo/default.png'),
(48, 3, 67, '2014sac', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', '2014sac', '2014sac', 1, 'photo/default.png'),
(49, 3, 1, 'Serena', '$2y$10$q2tSV3.o95bqHm1m7GjinegSd0PoydNPAqPnmTz6VRMschf7Li4XC', 'Xuanyu', 'Liu', 2, 'photo/default.png'),
(50, 3, 1, 'test01', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'test', 'TEST', 1, 'photo/default.png'),
(51, 3, 3, 'AGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, ''),
(53, 3, 3, 'BGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(54, 3, 3, 'CGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(55, 3, 3, 'DGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(56, 3, 3, 'EGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(57, 3, 3, 'FGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(58, 3, 3, 'GGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(59, 3, 3, 'HGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(60, 3, 3, 'IGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(61, 3, 3, 'JGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(62, 3, 3, 'KGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(63, 3, 3, 'MGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(64, 3, 3, 'LGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png'),
(65, 3, 3, 'NGROUP', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'A', 'GROUP', 2, 'photo/default.png');


--
-- Dumping data for table `t_group`
--

INSERT INTO `t_group` (`id_group`, `id_owner`, `group_name`, `activate_status`) VALUES
(1, 1, 'Group Test 1', 1);

--
-- Dumping data for table `t_group_member`
--

INSERT INTO `t_group_member` (`id_group`, `id_user`, `accept_status`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 49, 2),
(1, 50, 2);

--
-- Dumping data for table `t_record`
--

INSERT INTO `t_record` (`id_record`, `id_group`, `id_user`, `message_type`, `content`, `time`, `display_status`) VALUES
(1, 1, 1, 1, 'Hello!', '2015-07-07 21:55:08', 1),
(2, 1, 1, 1, 'Hi!', '2015-07-07 21:55:13', 1),
(3, 1, 2, 1, 'Thanks!', '2015-07-07 21:55:37', 1);

