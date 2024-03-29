DELIMITER $$
CREATE OR REPLACE TRIGGER createCourseAttendanceSubmission
    AFTER INSERT ON Course
    FOR EACH ROW
    BEGIN
        INSERT INTO CourseSubmission(course_code, submission_id, topic, allocated_point, visibility)
        VALUES (NEW.course_code, 'A001', 'Attendance', 0, FALSE);
    END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE TRIGGER createCourseSubmToStuCourseAttendSubm
    AFTER INSERT ON CourseSubmission
    FOR EACH ROW
BEGIN
    DECLARE stu_reg_no_ VARCHAR(12);
    DECLARE done INT DEFAULT FALSE;
    DECLARE get_stu_reg_no CURSOR FOR
        SELECT stu_reg_no
        FROM StuCourse
        WHERE course_code = NEW.course_code;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN get_stu_reg_no;
    stu_reg_no_loop: LOOP
        FETCH get_stu_reg_no INTO stu_reg_no_;
        IF done THEN
            LEAVE stu_reg_no_loop;
        END IF;

        INSERT INTO StuCourseSubmission(stu_reg_no, course_code, submission_id)
        VALUES (stu_reg_no_, NEW.course_code, NEW.submission_id);
    END LOOP;
    CLOSE get_stu_reg_no;
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE TRIGGER createStuToStuCourseAttendSubm
    AFTER INSERT ON StuCourse
    FOR EACH ROW
BEGIN
    INSERT INTO StuCourseSubmission(stu_reg_no, course_code, submission_id, stu_submission_point, state)
    VALUES (NEW.stu_reg_no, NEW.course_code, 'A001', 0, 'Done');
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER compositeKey
    BEFORE INSERT ON coursesubmission
    FOR EACH ROW BEGIN
    SET NEW.submission_id = (
       SELECT IFNULL(MAX(submission_id), 0) + 1
       FROM coursesubmission
       WHERE course_code  = NEW.course_code
    );
END $$
DELIMITER ;

-- Assign Students to course SubTopics
DELIMITER $$
CREATE OR REPLACE TRIGGER assignStudentForSubTopics
	AFTER INSERT ON stucourse
	FOR EACH ROW
BEGIN
    DECLARE topic_id_ INT;
    DECLARE sub_topic_id_ DECIMAL(4,2);
    DECLARE done INT DEFAULT FALSE;
    DECLARE get_subtopics CURSOR FOR
        SELECT topic_id, sub_topic_id
        FROM CourseSubtopic
        WHERE course_code = NEW.course_code;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN get_subtopics;
    get_subtopic_: LOOP
        FETCH get_subtopics INTO topic_id_, sub_topic_id_;
        IF done THEN
            LEAVE get_subtopic_;
        END IF;

        INSERT INTO stucoursesubtopic(stu_reg_no, course_code, topic_id, sub_topic_id)
        VALUES (NEW.stu_reg_no, NEW.course_code, topic_id_, sub_topic_id_);
    END LOOP;
    CLOSE get_subtopics;
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `delete_submissions`;
DELIMITER $$
CREATE TRIGGER `delete_submissions`
AFTER DELETE ON `coursesubmission`
FOR EACH ROW
BEGIN
DELETE FROM StuCourseSubmission WHERE submission_id=OLD.submission_id AND course_code=OLD.course_code;
END $$
DELIMITER ;


-- DELIMITER $$
-- CREATE OR REPLACE FUNCTION validateRegNoInSiteAnnouncement(reg_no_ VARCHAR(12)) RETURNS BOOLEAN
-- BEGIN
--     DECLARE count_ INT;
--
--     DECLARE get_admin_reg_no CURSOR FOR
--     	SELECT COUNT(a.reg_no)
--         FROM Admin a
--         WHERE a.reg_no = reg_no_;
--
--     DECLARE get_coord_reg_no CURSOR FOR
--     	SELECT COUNT(a.reg_no)
--         FROM AcademicStaff a
--         WHERE a.reg_no = reg_no_
--         AND a.degree_program_code IS NOT NULL;
--
--     OPEN get_admin_reg_no;
--     FETCH get_admin_reg_no INTO count_;
--     CLOSE get_admin_reg_no;
--     IF count_ > 0 THEN
--         RETURN TRUE;
-- 	END IF;
--
--     OPEN get_coord_reg_no;
--     FETCH get_coord_reg_no INTO count_;
--     CLOSE get_coord_reg_no;
--
--     IF count_ > 0 THEN
--     	RETURN TRUE;
--     END IF;
--
--     RETURN FALSE;
-- END $$
-- DELIMITER ;
--
--
-- DELIMITER $$
-- CREATE OR REPLACE TRIGGER FK_Trigger_SiteAnnouncement_Admin
-- BEFORE INSERT ON SiteAnnouncement
-- FOR EACH ROW
-- BEGIN
--     IF NOT validateRegNo(NEW.admin_reg_no) THEN
--     -- raises an error using the SIGNAL statement. The SIGNAL statement sets the SQLSTATE value to '45000',
--     -- which is a custom error code indicating that the error was raised by the trigger, and sets the MESSAGE_TEXT to a custom error message.
--     	SIGNAL SQLSTATE '45000'
--         	SET MESSAGE_TEXT = 'Cannot insert into SiteAnnouncement: invalid admin_reg_no.';
--     END IF;
-- END $$
-- DELIMITER ;
--
-- DELIMITER $$
-- CREATE OR REPLACE TRIGGER FK_Trigger_SiteAnnouncement_AcademicStaff
-- BEFORE INSERT ON SiteAnnouncement
-- FOR EACH ROW
-- BEGIN
--     IF NOT validateRegNo(NEW.cord_reg_no) THEN
--     -- raises an error using the SIGNAL statement. The SIGNAL statement sets the SQLSTATE value to '45000',
--     -- which is a custom error code indicating that the error was raised by the trigger, and sets the MESSAGE_TEXT to a custom error message.
--     	SIGNAL SQLSTATE '45000'
--         	SET MESSAGE_TEXT = 'Cannot insert into SiteAnnouncement: invalid cord_reg_no.';
--     END IF;
-- END $$
-- DELIMITER ;
