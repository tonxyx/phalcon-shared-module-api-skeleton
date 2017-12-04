--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `profilesId`, `resource`, `action`) VALUES
(1, 3, 'backend_index', 'index'),
(2, 1, 'backend_index', 'index'),
(3, 1, 'backend_users', 'index'),
(4, 1, 'backend_users', 'search'),
(5, 1, 'backend_users', 'edit'),
(6, 1, 'backend_users', 'create'),
(7, 1, 'backend_users', 'delete'),
(8, 1, 'backend_users', 'changePassword'),
(9, 1, 'backend_profiles', 'index'),
(10, 1, 'backend_profiles', 'search'),
(11, 1, 'backend_profiles', 'edit'),
(12, 1, 'backend_profiles', 'create'),
(13, 1, 'backend_profiles', 'delete'),
(14, 1, 'backend_permissions', 'index'),
(15, 2, 'backend_index', 'index'),
(16, 2, 'backend_users', 'index'),
(17, 2, 'backend_users', 'search'),
(18, 2, 'backend_users', 'edit'),
(19, 2, 'backend_users', 'create'),
(20, 2, 'backend_users', 'delete'),
(21, 2, 'backend_users', 'changePassword'),
(22, 2, 'backend_profiles', 'index'),
(23, 2, 'backend_profiles', 'search'),
(24, 2, 'backend_profiles', 'edit'),
(25, 2, 'backend_profiles', 'create'),
(26, 2, 'backend_profiles', 'delete');

-- --------------------------------------------------------

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `active`) VALUES
(1, 'Superadmin', 1),
(2, 'Admin', 1),
(3, 'Basic', 1);

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mustChangePassword`, `profilesId`, `banned`, `suspended`, `active`) VALUES
(1, 'PSMAS Admin', 'psmas@example.com', '$2y$08$RzBldkRER0tzVDhza3NPTu7hqsWzwV02nTas0eLc4vrgn0GH4lDmy', 0, 1, 0, 0, 1);
