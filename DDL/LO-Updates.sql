--UPDATE Statements

--general profile information change
UPDATE `linkedout`.`users`
	SET /*col1=val1, col2=val2, etc*/
	WHERE `user_id` = ?;

--update education entry
UPDATE `linkedout`.`education`
	SET /*col1=val1, col2=val2, etc*/ 
	WHERE `user_id` = ? AND `education_entry` = ?;

--update work_experience entry
UPDATE `linkedout`.`work_experience`
	SET /*col1=val1, col2=val2, etc*/
	WHERE `user_id` = ? AND `education_entry` = ?;

--update organization
UPDATE `linkedout`.`organizations`
	SET /*col1=val1, col2=val2, etc*/
	WHERE `org_id` = ?;
