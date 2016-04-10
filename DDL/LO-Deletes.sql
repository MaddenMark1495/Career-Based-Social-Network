--DELETE Statements

--delete user profile (cascade deletes all other associations with this user_id)
DELETE FROM `linkedout`.`users`
	WHERE `user_id` = ?;

--delete user skill
DELETE FROM `linkedout`.`user_skills`
	WHERE `user_id` = ?;

--delete user language
DELETE FROM `linkedout`.`user_languages`
	WHERE `user_id` = ?;

--delete user organization
DELETE FROM `linkedout`.`user_orgs`
	WHERE (`user_id` = ? AND `org_id` = ?);

--delete linked friend (not guaranteed which column user_ids are in so have to check for both directions)
DELETE FROM `linkedout`.`links`
	WHERE (`user_id` = ? AND `linked_user_id` = ?)
		OR (`user_id` = ? AND `linked_user_id` = ?);

--delete education entry
DELETE FROM `linkedout`.`education`
	WHERE (`user_id` = ? AND `education_entry` = ?);

--delete work experience entry
DELETE FROM `linkedout`.`work_experience`
	WHERE (`user_id` = ? AND `experience_entry` = ?);
