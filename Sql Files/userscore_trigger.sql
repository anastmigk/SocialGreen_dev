USE `sgalpha`;
DELIMITER $$

CREATE TRIGGER `userscore_trigger` AFTER INSERT ON activity FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	
	SET sum_leaves  = (SELECT ((sum(act.aluminium)*3)+(sum(act.glass)*1)+(sum(act.plastic)*2)) as LEAVES
	FROM sgalpha.activity as act
	WHERE act.userid = NEW.userid );

	UPDATE sgalpha.accounts SET points = sum_leaves WHERE accounts.id= NEW.userid ;

END$$
DELIMITER ;