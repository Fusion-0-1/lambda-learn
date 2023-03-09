DROP FUNCTION IF EXISTS validateRegNoInSiteAnnouncement;
DELIMITER $$
CREATE FUNCTION validateRegNoInSiteAnnouncement(reg_no_ VARCHAR(12)) RETURNS BOOLEAN
BEGIN
    DECLARE count_ INT;
    
    DECLARE get_admin_reg_no CURSOR FOR 
    	SELECT COUNT(a.reg_no)
        FROM Admin a
        WHERE a.reg_no = reg_no_;
        
    DECLARE get_coord_reg_no CURSOR FOR 
    	SELECT COUNT(a.reg_no)
        FROM AcademicStaff a
        WHERE a.reg_no = reg_no_
        AND a.degree_program_code IS NOT NULL;
    
    OPEN get_admin_reg_no;
    FETCH get_admin_reg_no INTO count_;
    CLOSE get_admin_reg_no;
    IF count_ > 0 THEN
        RETURN TRUE;
	END IF;
    
    OPEN get_coord_reg_no;
    FETCH get_coord_reg_no INTO count_;
    CLOSE get_coord_reg_no;
    
    IF count_ > 0 THEN
    	RETURN TRUE;
    END IF;
    
    RETURN FALSE;
END $$
DELIMITER ;


DROP TRIGGER IF EXISTS FK_Trigger_SiteAnnouncement_Admin;
DELIMITER $$
CREATE TRIGGER FK_Trigger_SiteAnnouncement_Admin
BEFORE INSERT ON SiteAnnouncement
FOR EACH ROW
BEGIN
    IF NOT validateRegNo(NEW.admin_reg_no) THEN
    -- raises an error using the SIGNAL statement. The SIGNAL statement sets the SQLSTATE value to '45000', 
    -- which is a custom error code indicating that the error was raised by the trigger, and sets the MESSAGE_TEXT to a custom error message.
    	SIGNAL SQLSTATE '45000'
        	SET MESSAGE_TEXT = 'Cannot insert into SiteAnnouncement: invalid admin_reg_no.';
    END IF;
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS FK_Trigger_SiteAnnouncement_AcademicStaff;
DELIMITER $$
CREATE TRIGGER FK_Trigger_SiteAnnouncement_AcademicStaff
BEFORE INSERT ON SiteAnnouncement
FOR EACH ROW
BEGIN
    IF NOT validateRegNo(NEW.cord_reg_no) THEN
    -- raises an error using the SIGNAL statement. The SIGNAL statement sets the SQLSTATE value to '45000', 
    -- which is a custom error code indicating that the error was raised by the trigger, and sets the MESSAGE_TEXT to a custom error message.
    	SIGNAL SQLSTATE '45000'
        	SET MESSAGE_TEXT = 'Cannot insert into SiteAnnouncement: invalid cord_reg_no.';
    END IF;
END $$
DELIMITER ;
