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
(1, 1, 1, 'root1', 'root1', 'Anakin', 'Skywalker', 1, 'photo/default.png');

INSERT INTO `discussion`.`t_user` (`id_role`, `id_department`, `username`, `password`, `first_name`, `last_name`, `gender`, `photo_url`) VALUES 
('1', '1', 'root2', 'root2', 'rootfirstname', 'rootlastname', '2', 'photo/default.png'),

('2', '2', 'stevens', 'stevens', 'stevensfn', 'stevensln', 1, 'photo/default.png'),
('2', '3', 'newyork', 'newyork', 'newyorkfn', 'newyorkln', 2, 'photo/default.png'),
('2', '4', 'columbia', 'columbia', 'columbiafn', 'columbialn', 1, 'photo/default.png'),
('2', '5', 'cunybaruch', 'cunybaruch', 'cunyfn', 'cunyln', 1, 'photo/default.png'),
('3', '26', 'stevenscs', 'stevenscs', 'stevenscsfn', 'stevensln', 1, 'photo/default.png'),
('3', '27', 'stevensee', 'stevensee', 'stevenseefn', 'stevensln', 1, 'photo/default.png'),
('3', '28', 'stevensfe', 'stevensfe', 'stevensfefn', 'stevensfeln', 1, 'photo/default.png'),
('3', '29', 'stevensce', 'stevenscs', 'stevenscefn', 'stevensceln', 1, 'photo/default.png'),
('3', '30', 'newyorkhi', 'newyorkhi', 'newyorkhifn', 'newyorkhiln', 1, 'photo/default.png'),
('3', '31', 'newyorkmu', 'newyorkmu', 'newyorkmufn', 'newyorkmuln', 1, 'photo/default.png'),
('3', '32', 'newyorksp', 'newyorksp', 'newyorkspfn', 'newyorkspln', 1, 'photo/default.png'),
('3', '33', 'columbiage', 'columbiage', 'columbiagefn', 'columbiageln', 1, 'photo/default.png'),
('3', '34', 'columbiaco', 'columbiaco', 'columbiacofn', 'columbiacoln', 1, 'photo/default.png'),
('3', '35', 'columbiabd', 'columbiabd', 'columbiabdfn', 'columbiabdfn', 1, 'photo/default.png'),
('3', '36', 'cunybm', 'cunybm', 'cunybmfn', 'cunybmln', 1, 'photo/default.png'),
('3', '37', 'cunyhr', 'cumyhr', 'cunyhrfn', 'cunyhrln', 1, 'photo/default.png'),
('3', '38', 'cunyec', 'cunyec', 'cunyecfn', 'cunyecln', 2, 'photo/default.png'),
('3', '39', 'cunyac', 'cunyac', 'cunyacfn', 'cunyacln', 1, 'photo/default.png'),
('3', '40', '2014fcs', '2014fcs', '2014fcs', '2014fcs', 1, 'photo/default.png'),
('3', '41', '2014scs', '2014scs', '2014scs', '2014scs', 1, 'photo/default.png'),
('3', '42', '2014fee', '2014fee', '2014fee', '2014fee', 1, 'photo/default.png'),
('3', '43', '2014see', '2014see', '2014see', '2014see', 1, 'photo/default.png'),
('3', '44', '2014ffe', '2014ffe', '2014ffe', '2014ffe', 1, 'photo/default.png'),
('3', '45', '2014sfe', '2014sfe', '2014sfe', '2014sfe', 2, 'photo/default.png'),
('3', '46', '2014fce', '2014fce', '2014fce', '2014fce', 1, 'photo/default.png'),
('3', '47', '2014sce', '2014sce', '2014sce', '2014sce', 2, 'photo/default.png'),
('3', '48', '2014fhi', '2014fhi', '2014fhi', '2014fhi', 1, 'photo/default.png'),
('3', '49', '2014shi', '2014shi', '2014shi', '2014shi', 1, 'photo/default.png'),
('3', '50', '2014fmu', '2014fmu', '2014fmu', '2014fmu', 2, 'photo/default.png'),
('3', '51', '2014smu', '2014smu', '2014smu', '2014smu', 1, 'photo/default.png'),
('3', '52', '2014fsp', '2014fsp', '2014fsp', '2014fsp', 2, 'photo/default.png'),
('3', '53', '2014ssp', '2014ssp', '2014ssp', '2014ssp', 1, 'photo/default.png'),
('3', '54', '2014fge', '2014fge', '2014fge', '2014fge', 1, 'photo/default.png'),
('3', '55', '2014sge', '2014sge', '2014sge', '2014sge', 1, 'photo/default.png'),
('3', '56', '2014fco', '2014fco', '2014fco', '2014fco', 2, 'photo/default.png'),
('3', '57', '2014sco', '2014sco', '2014sco', '2014sco', 2, 'photo/default.png'),
('3', '58', '2014fbd', '2014fbd', '2014fbd', '2014fbd', 1, 'photo/default.png'),
('3', '59', '2014sbd', '2014sbd', '2014sbd', '2014sbd', 1, 'photo/default.png'),
('3', '60', '2014fbm', '2014fbm', '2014fbm', '2014fbm', 1, 'photo/default.png'),
('3', '61', '2014sbm', '2014sbm', '2014sbm', '2014sbm', 2, 'photo/default.png'),
('3', '62', '2014fhr', '2014fhr', '2014fhr', '2014fhr', 1, 'photo/default.png'),
('3', '63', '2014shr', '2014shr', '2014shr', '2014shr', 2, 'photo/default.png'),
('3', '64', '2014feo', '2014feo', '2014feo', '2014feo', 2, 'photo/default.png'),
('3', '65', '2014seo', '2014seo', '2014seo', '2014seo', 1, 'photo/default.png'),
('3', '66', '2014fac', '2014fac', '2014fac', '2014fac', 1, 'photo/default.png'),
('3', '67', '2014sac', '2014sac', '2014sac', '2014sac', 1, 'photo/default.png');



