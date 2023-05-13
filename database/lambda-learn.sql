DROP DATABASE IF EXISTS `lambda-learn`;
CREATE DATABASE `lambda-learn`;
 
USE `lambda-learn`;
 
DROP TABLE IF EXISTS Student;
CREATE TABLE Student (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME,
    last_logout DATETIME,
    password VARCHAR(60) NOT NULL,
    active_status BOOLEAN,
    profile_picture VARCHAR(100),
    index_no INT NOT NULL,
    date_joined DATETIME NOT NULL,
    degree_program_code VARCHAR(5) NOT NULL,
    CONSTRAINT PK_Student PRIMARY KEY (reg_no)
);

DROP TABLE IF EXISTS AcademicStaff;
CREATE TABLE AcademicStaff (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,  
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME,
    last_logout DATETIME,
    password VARCHAR(60) NOT NULL,
    active_status BOOLEAN,
    profile_picture VARCHAR(100),
    degree_program_code VARCHAR(5),
    position VARCHAR(20) NOT NULL,
    CONSTRAINT PK_AcademicStaff PRIMARY KEY (reg_no)
);

DROP TABLE IF EXISTS Admin;
CREATE TABLE Admin (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,  
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME,
    last_logout DATETIME,
    password VARCHAR(60) NOT NULL,
    active_status BOOLEAN,
    profile_picture VARCHAR(100),
    CONSTRAINT PK_Admin PRIMARY KEY (reg_no)
);
 
DROP TABLE IF EXISTS Course;
CREATE TABLE Course (
    course_code VARCHAR(8) NOT NULL,
    course_name VARCHAR(50) NOT NULL,
    optional_flag BOOLEAN NOT NULL,
    cord_reg_no VARCHAR(12),
    date_created DATE,
    CONSTRAINT PK_Course PRIMARY KEY (course_code),
    CONSTRAINT FK_Course_AcademicStaff FOREIGN KEY (cord_reg_no) REFERENCES AcademicStaff(reg_no)
);

DROP TABLE IF EXISTS CourseTopic;
CREATE TABLE CourseTopic (
    course_code VARCHAR(8) NOT NULL,
    topic_id INT NOT NULL,
    topic VARCHAR(50) NOT NULL,
    CONSTRAINT PK_CourseTopic PRIMARY KEY (course_code, topic_id),
    CONSTRAINT FK_CourseTopic_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
);
 
DROP TABLE IF EXISTS CourseSubTopic;
CREATE TABLE CourseSubTopic (
    course_code VARCHAR(8) NOT NULL,
    topic_id INT NOT NULL,
    sub_topic_id DECIMAL(4,2) NOT NULL,
    sub_topic VARCHAR(50) NOT NULL,
    is_being_tracked BOOLEAN DEFAULT 0,
    lec_reg_no VARCHAR(12) NOT NULL,
    is_covered BOOLEAN DEFAULT 0,
    CONSTRAINT PK_CourseSubTopic PRIMARY KEY (course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_CourseSubTopic_CourseTopic FOREIGN KEY (course_code, topic_id) REFERENCES CourseTopic(course_code, topic_id),
    CONSTRAINT FK_CourseSubTopic_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
DROP TABLE IF EXISTS CourseSubTopicRec;
CREATE TABLE CourseSubTopicRec (
    course_code VARCHAR(8) NOT NULL,
    topic_id INT NOT NULL,
    sub_topic_id DECIMAL(4,2) NOT NULL,
    recording VARCHAR(100) NOT NULL,
    CONSTRAINT PK_CourseSubTopicRec PRIMARY KEY (course_code, topic_id, sub_topic_id, recording),
    CONSTRAINT FK_CourseSubTopicRec_CourseSubTopic FOREIGN KEY (course_code, topic_id, sub_topic_id) REFERENCES CourseSubTopic(course_code, topic_id, sub_topic_id)
);
   
DROP TABLE IF EXISTS CourseSubTopicSlide;
CREATE TABLE CourseSubTopicSlide (
    course_code VARCHAR(8) NOT NULL,
    topic_id INT NOT NULL,
    sub_topic_id DECIMAL(4,2) NOT NULL,
    slide VARCHAR(100) NOT NULL,
    CONSTRAINT PK_CourseSubTopicSlide PRIMARY KEY (course_code, topic_id, sub_topic_id, slide),
    CONSTRAINT FK_CourseSubTopicSlide_CourseSubTopic FOREIGN KEY (course_code, topic_id, sub_topic_id) REFERENCES CourseSubTopic(course_code, topic_id, sub_topic_id)
);
 
DROP TABLE IF EXISTS CourseSubmission;
CREATE TABLE CourseSubmission (
    course_code VARCHAR(8) NOT NULL,
    submission_id INT NOT NULL,
    topic VARCHAR(70) NOT NULL,
    description VARCHAR(500),
    allocated_mark INT,
    allocated_point INT,
    due_date DATETIME,
    visibility BOOLEAN,
    attachments VARCHAR(300),
    CONSTRAINT PK_CourseSubmission PRIMARY KEY (course_code, submission_id),
    CONSTRAINT FK_CourseSubmission_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
   
DROP TABLE IF EXISTS KanbanTask;
CREATE TABLE KanbanTask (
    task_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(300),
    due_date VARCHAR(20),
    state ENUM ("To Do", "In Progress", "Done") NOT NULL DEFAULT "To Do",
    priority ENUM ("Low", "Medium", "High") NOT NULL DEFAULT "Low",
    reg_no VARCHAR(12),
    CONSTRAINT PK_KanbanTask PRIMARY KEY (task_id)
);
 
DROP TABLE IF EXISTS TimeTableEvent;
CREATE TABLE TimeTableEvent (
    event_id INT NOT NULL AUTO_INCREMENT,
    course_code VARCHAR(8),
    location VARCHAR(15),
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    lec_reg_no VARCHAR(12),
    CONSTRAINT PK_TimeTableEvent PRIMARY KEY (event_id),
    CONSTRAINT FK_TimeTableEvent_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
DROP TABLE IF EXISTS SiteAnnouncement;
CREATE TABLE SiteAnnouncement (
    announcement_id INT NOT NULL AUTO_INCREMENT,
    heading VARCHAR(255) NOT NULL,
    content VARCHAR(1000) NOT NULL,
    publish_date DATETIME NOT NULL,
    admin_reg_no VARCHAR(12),
    cord_reg_no VARCHAR(12),
    CONSTRAINT PK_SiteAnnouncement PRIMARY KEY (announcement_id)
);
 
DROP TABLE IF EXISTS CourseAnnouncement;
CREATE TABLE CourseAnnouncement (
    announcement_id INT NOT NULL AUTO_INCREMENT,
    heading VARCHAR(255) NOT NULL,
    content VARCHAR(1000) NOT NULL,
    publish_date DATETIME NOT NULL,
    lec_reg_no VARCHAR(12),
    course_code VARCHAR(8),
    CONSTRAINT PK_CourseAnnouncement PRIMARY KEY (announcement_id),
    CONSTRAINT FK_CourseAnnouncement_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseAnnouncement_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
DROP TABLE IF EXISTS PerformanceHistory;
CREATE TABLE PerformanceHistory (
    record_date DATETIME DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,
    cpu_usage INT,
    total_memory INT, 
    used_memory INT, 
    unused_memory INT, 
    process_count INT, 
    process_running INT, 
    process_sleeping INT,
    CONSTRAINT PK_PerformanceHistory PRIMARY KEY (record_date)
);
 
DROP TABLE IF EXISTS AdminReport;
CREATE TABLE AdminReport (
    report_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    record_date DATETIME NOT NULL,
    CONSTRAINT PK_AdminReport PRIMARY KEY (report_id),
    CONSTRAINT FK_AdminReport_PerformanceHistory FOREIGN KEY (record_date) REFERENCES PerformanceHistory(record_date)
);
 
DROP TABLE IF EXISTS AttendanceReport;
CREATE TABLE AttendanceReport (
    report_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    path VARCHAR(255) NOT NULL,
    CONSTRAINT PK_AttendanceReport PRIMARY KEY (report_id)
);
 
DROP TABLE IF EXISTS ProgressReport;
CREATE TABLE ProgressReport (
    report_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_ProgressReport PRIMARY KEY (report_id, course_code),
    CONSTRAINT FK_ProgressReport_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
);
 
DROP TABLE IF EXISTS StuTimeTableEvent;
CREATE TABLE StuTimeTableEvent (
    stu_reg_no VARCHAR(12) NOT NULL,
    event_id INT NOT NULL,
    CONSTRAINT PK_StuTimeTableEvent PRIMARY KEY (stu_reg_no, event_id),
    CONSTRAINT FK_StuTimeTableEvent_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuTimeTableEvent_TimeTableEvent FOREIGN KEY (event_id) REFERENCES TimeTableEvent(event_id)
);
 
DROP TABLE IF EXISTS StuCourseSubTopic;
CREATE TABLE StuCourseSubTopic (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    topic_id INT NOT NULL,
    sub_topic_id DECIMAL(4,2) NOT NULL,
    is_completed BOOLEAN DEFAULT 0,
    CONSTRAINT PK_StuCourseSubTopic PRIMARY KEY (stu_reg_no, course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_StuCourseSubTopic_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourseSubTopic_CourseSubTopic FOREIGN KEY (course_code, topic_id, sub_topic_id) REFERENCES CourseSubTopic(course_code, topic_id, sub_topic_id)
);
 
DROP TABLE IF EXISTS StuCourse;
CREATE TABLE StuCourse (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    semester INT NOT NULL,
    exam_marks INT,
    CONSTRAINT PK_StuCourse PRIMARY KEY (stu_reg_no, course_code),
    CONSTRAINT FK_StuCourse_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourse_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
);  
 
DROP TABLE IF EXISTS LecCourse;
CREATE TABLE LecCourse (
    lec_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_LecCourse PRIMARY KEY (lec_reg_no, course_code),
    CONSTRAINT FK_LecCourse_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no),
    CONSTRAINT FK_LecCourse_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
);  
 
DROP TABLE IF EXISTS StuCourseSubmission;
CREATE TABLE StuCourseSubmission (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    submission_id INT NOT NULL,
    stu_submission_point INT,
    stu_submission_mark INT,
    state ENUM ("To Do", "In Progress", "Done") NOT NULL DEFAULT "To Do",
    CONSTRAINT PK_StuCourseSubmission PRIMARY KEY (stu_reg_no, course_code, submission_id),
    CONSTRAINT FK_StuCourseSubmission_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourseSubmission_CourseSubmission FOREIGN KEY (course_code, submission_id) REFERENCES CourseSubmission(course_code, submission_id) ON DELETE CASCADE ON UPDATE CASCADE
);

