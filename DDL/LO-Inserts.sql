-- INSERT Statements

--new user registration
INSERT INTO `linkedout`.`users` (`username`, `hashed_password`, `fname`, `lname`)
	VALUES (?, ?, ?, ?);

--link request accepted
INSERT INTO `linkedout`.`links` (`user_id`, `linked_user_id`, `linked_date`)
	VALUES (?, ?, CURDATE());

--add new major
INSERT INTO `linkedout`.`major` (`major_name`)
	VALUES (?);

--add new degree type
INSERT INTO `linkedout`.`degree_type` (`degree_type`)
	VALUES (?);

--add education entry to resume
INSERT INTO `linkedout`.`education` (`user_id`, `education_entry`, `school`, `deg_type_idx`, `major_idx`, `start_year`, `end_year`)
	VALUES (?, ?, ?, ?, ?, ?, ?);

--insert work experience entry
INSERT INTO `linkedout`.`work_experience` (`user_id`, `experience_entry`, `company`, `title`, `start_date`, `end_date`, `description`)
	VALUES (?, ?, ?, ?, ?, ?, ?);

--add new skill
INSERT INTO `linkedout`.`skills` (`skill`)
	VALUES (?);

--add user skill
INSERT INTO `linkedout`.`user_skills` (`user_id`,`skill_id`)
	VALUES (?, (SELECT `skill_id` FROM `linkedout`.`skills` WHERE `skill_name` = ?));

--add new language
INSERT INTO `linkedout`.`languages` (`language`) VALUES (?);

--add user language
INSERT INTO `linkedout`.`user_languages` (`user_id`, `lang_id`)
	VALUES (?, (SELECT `lang_id` FROM `linkedout`.`languages` WHERE `language` = ?));

--add new organization
INSERT INTO `linkedout`.`organizations` (`user_id`, `org_name`, `desription`)
	VALUES (?, ?, ?);

--add new organization member
INSERT INTO `linkdedout`.`user_orgs` (`user_id`, `org_id`)
	VALUES (?, ?);
