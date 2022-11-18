
DROP DATABASE IF EXISTS `lambda`;
CREATE DATABASE `lambda`;
 
USE `lambda`;
 
DROP TABLE IF EXISTS Student;
CREATE TABLE Student (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME NOT NULL,
    last_logout DATETIME NOT NULL,
    password VARCHAR(50) NOT NULL,
    active_status BOOLEAN NOT NULL,
    profile_picture VARCHAR(100),
    index_no INT NOT NULL,
    date_joined DATETIME NOT NULL,
    degree_program_code VARCHAR(5) NOT NULL,
    CONSTRAINT PK_Student PRIMARY KEY (reg_no));
 
DROP TABLE IF EXISTS AcademicStaff;
CREATE TABLE AcademicStaff (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,  
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME NOT NULL,
    last_logout DATETIME NOT NULL,
    password VARCHAR(50) NOT NULL,
    active_status BOOLEAN NOT NULL,
    profile_picture VARCHAR(100),
    degree_program_code VARCHAR(5),
    CONSTRAINT PK_AcademicStaff PRIMARY KEY (reg_no));
 
DROP TABLE IF EXISTS Admin;
CREATE TABLE Admin (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,  
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    personal_email VARCHAR(50),
    contact_no VARCHAR(12),
    last_login DATETIME NOT NULL,
    last_logout DATETIME NOT NULL,
    password VARCHAR(50) NOT NULL,
    active_status BOOLEAN NOT NULL,
    profile_picture VARCHAR(100),
    CONSTRAINT PK_Admin PRIMARY KEY (reg_no));
 
DROP TABLE IF EXISTS Course;
CREATE TABLE Course (
    course_code VARCHAR(8) NOT NULL,
    course_name VARCHAR(50) NOT NULL,
    optional_flag BOOLEAN NOT NULL,
    cord_reg_no VARCHAR(12) NOT NULL,
    CONSTRAINT PK_Course PRIMARY KEY (course_code),
    CONSTRAINT FK_Course_AcademicStaff FOREIGN KEY (cord_reg_no) REFERENCES AcademicStaff(reg_no));
 
DROP TABLE IF EXISTS CourseTopic;
CREATE TABLE CourseTopic (
    course_code VARCHAR(8) NOT NULL,
    topic_id DECIMAL(3,3) NOT NULL,
    topic VARCHAR(50) NOT NULL,
    CONSTRAINT PK_CourseTopic PRIMARY KEY (course_code, topic_id),
    CONSTRAINT FK_CourseTopic_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));
 
DROP TABLE IF EXISTS CourseSubTopic;
CREATE TABLE CourseSubTopic (
    course_code VARCHAR(8) NOT NULL,
    topic_id DECIMAL(3,3) NOT NULL,
    sub_topic_id VARCHAR(8) NOT NULL,
    sub_topic VARCHAR(50) NOT NULL,
    is_being_tracked BOOLEAN NOT NULL,
    lec_reg_no VARCHAR(12) NOT NULL,
    CONSTRAINT PK_CourseSubTopic PRIMARY KEY (course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_CourseSubTopic_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseSubTopic_CourseTopic FOREIGN KEY (topic_id) REFERENCES CourseTopic(topic_id),
    CONSTRAINT FK_CourseSubTopic_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no));
 
DROP TABLE IF EXISTS CourseSubTopicRec;
CREATE TABLE CourseSubTopicRec (
    course_code VARCHAR(8) NOT NULL,
    topic_id DECIMAL(3,3) NOT NULL,
    sub_topic_id VARCHAR(8) NOT NULL,
    recording VARCHAR(100) NOT NULL,
    CONSTRAINT PK_CourseSubTopicRec PRIMARY KEY (course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_CourseSubTopicRec_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseSubTopicRec_CourseTopic FOREIGN KEY (topic_id) REFERENCES CourseTopic(topic_id),
    CONSTRAINT FK_CourseSubTopicRec_CourseSubTopic FOREIGN KEY (sub_topic_id) REFERENCES CourseSubTopic(sub_topic_id));
   
DROP TABLE IF EXISTS CourseSubTopicSlide;
CREATE TABLE CourseSubTopicSlide (
    course_code VARCHAR(8) NOT NULL,
    topic_id DECIMAL(3,3) NOT NULL,
    sub_topic_id VARCHAR(8) NOT NULL,
    slide VARCHAR(100) NOT NULL,
    CONSTRAINT PK_CourseSubTopicSlide PRIMARY KEY (course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_CourseSubTopicSlide_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseSubTopicSlide_CourseTopic FOREIGN KEY (topic_id) REFERENCES CourseTopic(topic_id),
    CONSTRAINT FK_CourseSubTopicSlide_CourseSubTopic FOREIGN KEY (sub_topic_id) REFERENCES CourseSubTopic(sub_topic_id));
 
DROP TABLE IF EXISTS CourseSubmission;
CREATE TABLE CourseSubmission (
    course_code VARCHAR(8) NOT NULL,
    submission_id VARCHAR(4) NOT NULL,
    topic VARCHAR(70) NOT NULL,
    description VARCHAR(300),
    allocated_mark INT,
    allocated_point INT,
    due_date DATETIME NOT NULL,
    visibility BOOLEAN,
    CONSTRAINT PK_CourseSubmission PRIMARY KEY (course_code, submission_id),
    CONSTRAINT FK_CourseSubmission_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));
   
DROP TABLE IF EXISTS KanbanTask;
CREATE TABLE KanbanTask (
    task_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(300),
    due_date DATETIME,
    state INT NOT NULL,
    submission_id VARCHAR(4),
    stu_reg_no VARCHAR(12) NOT NULL,
    lec_reg_no VARCHAR(12),
    CONSTRAINT PK_KanbanTask PRIMARY KEY (task_id),
    CONSTRAINT FK_KanbanTask_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_KanbanTask_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no),
    CONSTRAINT FK_KanbanTask_CourseSubmission FOREIGN KEY (submission_id) REFERENCES CourseSubmission(submission_id));
 
DROP TABLE IF EXISTS TimeTableEvent;
CREATE TABLE TimeTableEvent (
    event_id INT NOT NULL,
    course_code VARCHAR(8),
    location VARCHAR(15),
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    lec_reg_no VARCHAR(12),
    CONSTRAINT PK_TimeTableEvent PRIMARY KEY (event_id),
    CONSTRAINT FK_TimeTableEvent_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no));
 
DROP TABLE IF EXISTS SiteAnnouncement;
CREATE TABLE SiteAnnouncement (
    announcement_id INT NOT NULL,
    heading VARCHAR(50) NOT NULL,
    content VARCHAR(300) NOT NULL,
    date DATETIME NOT NULL,
    admin_reg_no VARCHAR(12),
    cord_reg_no VARCHAR(12),
    CONSTRAINT PK_SiteAnnouncement PRIMARY KEY (announcement_id),
    CONSTRAINT FK_SiteAnnouncement_Admin FOREIGN KEY (admin_reg_no) REFERENCES Admin(reg_no),
    CONSTRAINT FK_SiteAnnouncement_AcademicStaff FOREIGN KEY (cord_reg_no) REFERENCES AcademicStaff(reg_no));
 
DROP TABLE IF EXISTS CourseAnnouncement;
CREATE TABLE CourseAnnouncement (
    announcement_id INT NOT NULL,
    heading VARCHAR(50) NOT NULL,
    content VARCHAR(300) NOT NULL,
    date DATETIME NOT NULL,
    lec_reg_no VARCHAR(12),
    course_code VARCHAR(8),
    CONSTRAINT PK_CourseAnnouncement PRIMARY KEY (announcement_id),
    CONSTRAINT FK_CourseAnnouncement_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseAnnouncement_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no));
 
DROP TABLE IF EXISTS PerformanceHistory;
CREATE TABLE PerformanceHistory (
    date_time DATETIME NOT NULL,
    cpu_usage VARCHAR(6),
    ram_usage VARCHAR(6),
    storage_usage VARCHAR(6),
    concurrent_users VARCHAR(6),
    CONSTRAINT PK_PerformanceHistory PRIMARY KEY (date_time));
 
DROP TABLE IF EXISTS AdminReport;
CREATE TABLE AdminReport (
    report_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    date_time DATETIME NOT NULL,
    CONSTRAINT PK_AdminReport PRIMARY KEY (report_id),
    CONSTRAINT FK_AdminReport_PerformanceHistory FOREIGN KEY (date_time) REFERENCES PerformanceHistory(date_time));
 
DROP TABLE IF EXISTS AttendanceReport;
CREATE TABLE AttendanceReport (
    report_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_AttendanceReport PRIMARY KEY (report_id, course_code),
    CONSTRAINT FK_AttendanceReport_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));
 
DROP TABLE IF EXISTS ProgressReport;
CREATE TABLE ProgressReport (
    report_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_ProgressReport PRIMARY KEY (report_id, course_code),
    CONSTRAINT FK_ProgressReport_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));
 
DROP TABLE IF EXISTS StuTimeTableEvent;
CREATE TABLE StuTimeTableEvent (
    stu_reg_no VARCHAR(12) NOT NULL,
    event_id INT NOT NULL,
    CONSTRAINT PK_StuTimeTableEvent PRIMARY KEY (stu_reg_no, event_id),
    CONSTRAINT FK_StuTimeTableEvent_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuTimeTableEvent_TimeTableEvent FOREIGN KEY (event_id) REFERENCES TimeTableEvent(event_id));
 
DROP TABLE IF EXISTS StuCourseSubTopic;
CREATE TABLE StuCourseSubTopic (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    topic_id DECIMAL(3,3) NOT NULL,
    sub_topic_id VARCHAR(8) NOT NULL,
    is_completed BOOLEAN,
    CONSTRAINT PK_StuCourseSubTopic PRIMARY KEY (stu_reg_no, course_code, topic_id, sub_topic_id),
    CONSTRAINT FK_StuCourseSubTopic_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourseSubTopic_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_StuCourseSubTopic_CourseTopic FOREIGN KEY (topic_id) REFERENCES CourseTopic(topic_id),
    CONSTRAINT FK_StuCourseSubTopic_CourseSubTopic FOREIGN KEY (sub_topic_id) REFERENCES CourseSubTopic(sub_topic_id));
 
DROP TABLE IF EXISTS StuCourse;
CREATE TABLE StuCourse (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    semester INT NOT NULL,
    exam_marks INT,
    CONSTRAINT PK_StuCourse PRIMARY KEY (stu_reg_no, course_code),
    CONSTRAINT FK_StuCourse_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourse_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));  
 
DROP TABLE IF EXISTS LecCourse;
CREATE TABLE LecCourse (
    lec_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_LecCourse PRIMARY KEY (lec_reg_no, course_code),
    CONSTRAINT FK_LecCourse_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no),
    CONSTRAINT FK_LecCourse_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));  
 
DROP TABLE IF EXISTS StuCourseSubmission;
CREATE TABLE StuCourseSubmission (
    stu_reg_no VARCHAR(12) NOT NULL,
    submission_id VARCHAR(4) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    stu_submission_point INT,
    stu_submission_mark INT,
    CONSTRAINT PK_StuCourseSubmission PRIMARY KEY (stu_reg_no, submission_id, course_code),
    CONSTRAINT FK_StuCourseSubmission_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourseSubmission_CourseSubmission FOREIGN KEY (submission_id) REFERENCES CourseSubmission(submission_id),
    CONSTRAINT FK_StuCourseSubmission_Course FOREIGN KEY (course_code) REFERENCES Course(course_code));
 
