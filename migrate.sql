Migration table created successfully.
CreateUsersTable: create table `users` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `school` varchar(255) not null, `email` varchar(255) not null, `password` varchar(255) not null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateUsersTable: alter table `users` add unique `users_email_unique`(`email`)
CreatePasswordResetsTable: create table `password_resets` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp not null) default character set utf8 collate utf8_unicode_ci
CreatePasswordResetsTable: alter table `password_resets` add index `password_resets_email_index`(`email`)
CreatePasswordResetsTable: alter table `password_resets` add index `password_resets_token_index`(`token`)
CreateDelegatesTable: create table `delegates` (`id` int unsigned not null auto_increment primary key, `firstname` varchar(255) not null, `lastname` varchar(255) not null, `user_id` int unsigned not null, `lunch` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateDelegatesTable: alter table `delegates` add constraint `delegates_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade
CreateDelegatesTable: alter table `delegates` add index `delegates_user_id_index`(`user_id`)
CreateLunchesTable: create table `lunches` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateCountriesTable: create table `countries` (`id` int unsigned not null auto_increment primary key, `committee_id` int unsigned not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateCountriesTable: alter table `countries` add index `countries_committee_id_index`(`committee_id`)
CreateCommitteesTable: create table `committees` (`id` int unsigned not null auto_increment primary key, `committee` varchar(255) not null, `full_name` varchar(255) not null, `topic` varchar(255) not null, `chair_email` varchar(255) not null, `chair_name` varchar(255) not null, `high_school` tinyint(1) not null, `clone_of` int unsigned null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateCommitteesTable: alter table `committees` add constraint `committees_clone_of_foreign` foreign key (`clone_of`) references `committees` (`id`) on delete cascade
CreateCommitteesTable: alter table `committees` add index `committees_clone_of_index`(`clone_of`)
AddedPaymentsTable: create table `payments` (`id` int unsigned not null auto_increment primary key, `user_id` int unsigned not null, `amount` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
AddedPaymentsTable: alter table `payments` add constraint `payments_user_id_foreign` foreign key (`user_id`) references `users` (`id`)
AddedPaymentsTable: alter table `payments` add index `payments_user_id_index`(`user_id`)
CreateAdminsTable: create table `admins` (`id` int unsigned not null auto_increment primary key, `user_id` int unsigned not null, `chair_access_only` tinyint(1) not null default '1', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateAdminsTable: alter table `admins` add constraint `admins_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade
CreateAdminsTable: alter table `admins` add index `admins_user_id_index`(`user_id`)
UnauthorizedAttempts: create table `unathorizedAttempts` (`id` int unsigned not null auto_increment primary key, `ip` varchar(255) not null, `user_id` int unsigned not null, `at` varchar(255) not null) default character set utf8 collate utf8_unicode_ci
UnauthorizedAttempts: alter table `unathorizedAttempts` add constraint `unathorizedattempts_user_id_foreign` foreign key (`user_id`) references `users` (`id`)
UnauthorizedAttempts: alter table `unathorizedAttempts` add index `unathorizedattempts_user_id_index`(`user_id`)
CreatePermissionTables: create table `roles` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreatePermissionTables: alter table `roles` add unique `roles_name_unique`(`name`)
CreatePermissionTables: create table `permissions` (`id` int unsigned not null auto_increment primary key, `name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreatePermissionTables: alter table `permissions` add unique `permissions_name_unique`(`name`)
CreatePermissionTables: create table `user_has_permissions` (`user_id` int unsigned not null, `permission_id` int unsigned not null) default character set utf8 collate utf8_unicode_ci
CreatePermissionTables: alter table `user_has_permissions` add constraint `user_has_permissions_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade
CreatePermissionTables: alter table `user_has_permissions` add constraint `user_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade
CreatePermissionTables: alter table `user_has_permissions` add primary key `user_has_permissions_user_id_permission_id_primary`(`user_id`, `permission_id`)
CreatePermissionTables: create table `role_has_permissions` (`permission_id` int unsigned not null, `role_id` int unsigned not null) default character set utf8 collate utf8_unicode_ci
CreatePermissionTables: alter table `role_has_permissions` add constraint `role_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade
CreatePermissionTables: alter table `role_has_permissions` add constraint `role_has_permissions_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade
CreatePermissionTables: alter table `role_has_permissions` add primary key `role_has_permissions_permission_id_role_id_primary`(`permission_id`, `role_id`)
CreatePermissionTables: create table `user_has_roles` (`role_id` int unsigned not null, `user_id` int unsigned not null) default character set utf8 collate utf8_unicode_ci
CreatePermissionTables: alter table `user_has_roles` add constraint `user_has_roles_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade
CreatePermissionTables: alter table `user_has_roles` add constraint `user_has_roles_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade
CreatePermissionTables: alter table `user_has_roles` add primary key `user_has_roles_role_id_user_id_primary`(`role_id`, `user_id`)
CreatePositionsTable: create table `positions` (`id` int unsigned not null auto_increment primary key, `committee_id` int unsigned null, `name` varchar(255) not null, `delegate` int unsigned null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreatePositionsTable: alter table `positions` add constraint `positions_committee_id_foreign` foreign key (`committee_id`) references `committees` (`id`)
CreatePositionsTable: alter table `positions` add constraint `positions_delegate_foreign` foreign key (`delegate`) references `delegates` (`id`)
CreatePositionsTable: alter table `positions` add index `positions_committee_id_index`(`committee_id`)
CreatePositionsTable: alter table `positions` add index `positions_delegate_index`(`delegate`)
CreateBriefingPapersTable: create table `briefing_papers` (`id` int unsigned not null auto_increment primary key, `committee_id` int unsigned null, `name` varchar(255) not null, `file_path` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateBriefingPapersTable: alter table `briefing_papers` add constraint `briefing_papers_committee_id_foreign` foreign key (`committee_id`) references `committees` (`id`)
CreateBriefingPapersTable: alter table `briefing_papers` add index `briefing_papers_committee_id_index`(`committee_id`)
AddAssignedDelegation: alter table `positions` add `user_id` int unsigned null
AddAssignedDelegation: alter table `positions` add constraint `positions_user_id_foreign` foreign key (`user_id`) references `users` (`id`)
AddAssignedDelegation: alter table `positions` add index `positions_user_id_index`(`user_id`)
CreateRequestsTable: create table `requests` (`id` int unsigned not null auto_increment primary key, `user_id` int unsigned not null, `committee_id` int unsigned not null, `amount` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate utf8_unicode_ci
CreateRequestsTable: alter table `requests` add constraint `requests_user_id_foreign` foreign key (`user_id`) references `users` (`id`)
CreateRequestsTable: alter table `requests` add constraint `requests_committee_id_foreign` foreign key (`committee_id`) references `committees` (`id`)
CreateRequestsTable: alter table `requests` add index `requests_user_id_index`(`user_id`)
CreateRequestsTable: alter table `requests` add index `requests_committee_id_index`(`committee_id`)
AddLevelCol: alter table `committees` add `level` varchar(255) not null
AddNotesCol: alter table `committees` add `notes` varchar(255) not null
AddPaymentNotes: alter table `payments` add `note` varchar(255) not null
