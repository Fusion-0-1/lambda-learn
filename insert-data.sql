
USE `lambda-learn`;

INSERT INTO Student (reg_no, first_name, last_name, email, personal_email, contact_no, password, index_no, date_joined, degree_program_code) VALUES
    ("2020/CS/0011", "Dilanga", "Harshani", "2020cs0011@fusion.ac.lk", "aadilanga@gmail.com", "772267962", "20000011@CS", 20000011, "2021-02-24", "CS"),
    ("2020/CS/0014", "Inuri", "Lavanya", "2020cs0014@fusion.ac.lk", "inurilavanya@gmail.com", "719267365", "20000014@CS", 20000014, "2021-02-24", "CS"),
    ("2020/CS/0026", "Ramindu", "Walgama", "2020cs0016@fusion.ac.lk", "rrwalgama2@gmail.com", "712028360", "20000026@CS", 20000026, "2021-02-24", "CS"),
    ("2020/CS/0044", "Anjana", "Silva", "2020cs0044@fusion.ac.lk", "anjana1.silva@gmail.com", "720261354", "20000044@CS", 20000044, "2021-02-24", "CS"),
    ("2020/IS/0016", "Ravin", "Dias", "2020is0016@fusion.ac.lk", "naravindias2510@gmail.com", "762349367", "21000016@CS", 21000016, "2021-02-24", "IS"),
    ("2020/IS/0032", "Aruni", "Samara", "2020is0032@fusion.ac.lk", "aruniisamaraa@gmail.com", "742934349", "21000032@CS", 21000032, "2021-02-24", "IS"),        
    ("2020/IS/0051", "Kavindu", "Fernando", "2020is0051@fusion.ac.lk", "fernandok@gmail.com", "752678334", "21000051@CS", 21000051, "2021-02-24", "IS"),
    ("2020/IS/0075", "Malsha", "Kavindi", "2020is0075@fusion.ac.lk", "malsha.kavi@gmail.com", "782025393", "21000075@CS", 21000075, "2021-02-24", "IS");

INSERT INTO AcademicStaff (reg_no, first_name, last_name, email, contact_no, password) VALUES
    ("2014/LC/0034", "Erandi", "Gamage", "2014lc0034@fusion.ac.lk", "772469621", "20140034@LC"),
    ("2008/LC/0002", "Naresh", "Rajan", "2008lc0002@fusion.ac.lk", "746682736", "20080002@LC"),
    ("2006/LC/0014", "Janani", "Walpola", "2006lc0014@fusion.ac.lk", "753028364", "20060014@LC"),
    ("2018/LC/0022", "Tissa", "Silva", "2018lc0022@fusion.ac.lk", "764861337", "20180022@LC"),
    ("2003/LC/0004", "Manoj", "Fernando", "2003lc0004@fusion.ac.lk", "742335368", "20030004@LC"),
    ("1999/LC/0008", "Mohomad", "Abdullah", "1999lc0008@fusion.ac.lk", "716934345", "19990008@LC"),        
    ("2016/LC/0015", "Kamani", "Perera", "2016lc0015@fusion.ac.lk", "752345331", "20160015@LC"),
    ("1998/LC/0019", "Sandya", "Kumari", "1998lc0019@fusion.ac.lk", "782645352", "19980019@LC");

UPDATE AcademicStaff SET degree_program_code = "CS" WHERE reg_no = "2003/LC/0004";
UPDATE AcademicStaff SET degree_program_code = "IS" WHERE reg_no = "1998/LC/0019";

INSERT INTO Admin (reg_no, first_name, last_name, email, contact_no, password) VALUES
    ("2018/AD/0012", "Suraj", "Pathirana", "2018ad0012@fusion.ac.lk", "716469634", "20180012@AD"),       
    ("2011/AD/0007", "Pathum", "Perera", "2011ad0007@fusion.ac.lk", "754533541", "20110007@AD"),
    ("2009/AD/0005", "Sisira", "Fernando", "2009ad0005@fusion.ac.lk", "777264452", "20090005@AD");

INSERT INTO Course (course_code, course_name, optional_flag, cord_reg_no) VALUES
    ("CS 2001", "Database Management", 0, "2003/LC/0004"),
    ("CS 2002", "Discrete Mathematics", 1, "2003/LC/0004"),
    ("CS 2003", "Data Stuctures", 0, "2003/LC/0004"),
    ("CS 2004", "Programming Algorithms", 1, "2003/LC/0004"),
    ("IS 2001", "Programming using C", 0, "1998/LC/0019"),
    ("IS 2002", "Rapid Application Development", 1, "1998/LC/0019"),
    ("IS 2003", "Laboratory 1", 0, "1998/LC/0019");

INSERT INTO CourseTopic (course_code, topic_id, topic) VALUES
    ("CS 2001", 01, "Types of Database Management Systems"),
    ("CS 2001", 02, "Data Modelling"),
    ("CS 2001", 03, "Querying a Databse"),
    ("CS 2002", 01, "Prepositions"),
    ("CS 2002", 02, "Sets"),
    ("CS 2002", 03, "Functions & Relations"),
    ("CS 2003", 01, "Stacks"),
    ("CS 2003", 02, "Queues"),
    ("CS 2003", 03, "Linked Lists"),
    ("CS 2004", 01, "Introduction"),
    ("CS 2004", 02, "Complexity Analysis"),
    ("CS 2004", 03, "Sorting Algorithms"),
    ("IS 2001", 01, "C Language"),
    ("IS 2001", 02, "Control Structures"),
    ("IS 2001", 03, "Handling Data Structures"),
    ("IS 2002", 01, "Rapid Application Development"),
    ("IS 2002", 02, "MERN Stack"),
    ("IS 2002", 03, "Agile Concepts"),
    ("IS 2003", 01, "Linux OS"),
    ("IS 2003", 02, "Text Editors"),
    ("IS 2003", 03, "Open Sourse Software");

INSERT INTO CourseSubTopic (course_code, topic_id, sub_topic_id, sub_topic, is_being_tracked, lec_reg_no) VALUES
    ("CS 2001", 01, 1.1, "Hierarchical Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.2, "Network Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.3, "Relational Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.4, "Object Relational Model", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.1, "Normalization", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.2, "Cardinality and Participation", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.3, "ER & EER Diagrams", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.1, "Query Languages", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.2, "MySQL CRUD Operations", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.3, "MySQL Joins", 1, "2014/LC/0034"),
    ("CS 2002", 01, 1.1, "Prepositional Logic", 1, "2006/LC/0014"),
    ("CS 2002", 01, 1.2, "Predicate Logic", 1, "2006/LC/0014"),
    ("CS 2002", 01, 1.3, "Arguments", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.1, "Set Notation", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.2, "Set Thoeries", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.3, "Solving Problems using Sets", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.1, "Functions", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.2, "Binary Relations", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.3, "Equivalance Relations", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.4, "Partial Order Relations", 1, "2006/LC/0014"),
    ("CS 2003", 01, 1.1, "Introduction to Stacks", 1, "2018/LC/0022"),
    ("CS 2003", 01, 1.2, "Implementing a Stack", 1, "2018/LC/0022"),
    ("CS 2003", 01, 1.3, "Adding & Deleting Data", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.1, "Introduction to Queues", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.2, "Implementing a Queue", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.3, "Adding & Deleting Data", 1, "2018/LC/0022"),
    ("CS 2003", 03, 3.1, "Introduction to Linked Lists", 1, "2003/LC/0004"),
    ("CS 2003", 03, 3.2, "Implementing a Linked List", 1, "2003/LC/0004"),
    ("CS 2003", 03, 3.3, "Adding & Deleting Nodes", 1, "2003/LC/0004"),
    ("CS 2004", 01, 1.1, "Algorithms", 1, "2003/LC/0004"),
    ("CS 2004", 01, 1.2, "Analysing Algorithms", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.1, "Big O Notation", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.2, "Big Omega Notation", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.3, "Big Theta Notation", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.1, "Bubble Sort", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.2, "Insertion Sort", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.3, "Selection Sort", 1, "2003/LC/0004"),
    ("IS 2001", 01, 1.1, "History of C Language", 1, "2018/LC/0022"),
    ("IS 2001", 01, 1.2, "Basic Syntax", 1, "2018/LC/0022"),
    ("IS 2001", 01, 1.3, "C Libraries", 1, "2018/LC/0022"),
    ("IS 2001", 02, 2.1, "Sequence", 1, "1999/LC/0008"),
    ("IS 2001", 02, 2.2, "Selection", 1, "1999/LC/0008"),
    ("IS 2001", 02, 2.3, "Iteration", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.1, "Stacks using C", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.2, "Queues using C", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.3, "Linked Lists using C", 1, "1999/LC/0008"),
    ("IS 2002", 01, 1.1, "History of RAD", 1, "2014/LC/0034"),
    ("IS 2002", 01, 1.2, "Principles of RAD", 1, "2014/LC/0034"),
    ("IS 2002", 01, 1.3, "JavaScript", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.1, "Mongo DB", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.2, "Express JS", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.3, "React JS", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.4, "Node JS", 1, "2016/LC/0015"),
    ("IS 2002", 03, 3.1, "Agile Principles", 1, "2014/LC/0034"),
    ("IS 2002", 03, 3.2, "Agile Practices", 1, "2014/LC/0034"),
    ("IS 2002", 03, 3.3, "Agile Testing", 1, "2014/LC/0034"),
    ("IS 2003", 01, 1.1, "History of Linux", 1, "1998/LC/0019"),
    ("IS 2003", 01, 1.2, "Linux Distributions", 1, "1998/LC/0019"),
    ("IS 2003", 01, 1.3, "Installation", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.1, "VIM Editor", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.2, "Nano Editor", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.3, "LaTeX", 1, "1998/LC/0019"),
    ("IS 2003", 03, 3.1, "Libre Office", 1, "1998/LC/0019"),
    ("IS 2003", 03, 3.2, "GIMP", 1, "1998/LC/0019");
 
INSERT INTO CourseSubTopicRec (course_code, topic_id, sub_topic_id) VALUES
    ("CS 2001", 01, 01.1),
    ("CS 2001", 01, 01.2),
    ("CS 2001", 01, 01.3),
    ("CS 2001", 01, 01.4),
    ("CS 2001", 02, 02.1),
    ("CS 2001", 02, 02.2),
    ("CS 2001", 02, 02.3),
    ("CS 2001", 03, 03.1),
    ("CS 2001", 03, 03.2),
    ("CS 2001", 03, 03.3),
    ("CS 2002", 01, 01.1),
    ("CS 2002", 01, 01.2),
    ("CS 2002", 01, 01.3),
    ("CS 2002", 02, 02.1),
    ("CS 2002", 02, 02.2),
    ("CS 2002", 02, 02.3),
    ("CS 2002", 03, 03.1),
    ("CS 2002", 03, 03.2),
    ("CS 2002", 03, 03.3),
    ("CS 2002", 03, 03.4),
    ("CS 2003", 01, 01.1),
    ("CS 2003", 01, 01.2),
    ("CS 2003", 01, 01.3),
    ("CS 2003", 02, 02.1),
    ("CS 2003", 02, 02.2),
    ("CS 2003", 02, 02.3),
    ("CS 2003", 03, 03.1),
    ("CS 2003", 03, 03.2),
    ("CS 2003", 03, 03.3),
    ("CS 2004", 01, 01.1),
    ("CS 2004", 01, 01.2),
    ("CS 2004", 02, 02.1),
    ("CS 2004", 02, 02.2),
    ("CS 2004", 02, 02.3),
    ("CS 2004", 03, 03.1),
    ("CS 2004", 03, 03.2),
    ("CS 2004", 03, 03.3),
    ("IS 2001", 01, 01.1),
    ("IS 2001", 01, 01.2),
    ("IS 2001", 01, 01.3),
    ("IS 2001", 02, 02.1),
    ("IS 2001", 02, 02.2),
    ("IS 2001", 02, 02.3),
    ("IS 2001", 03, 03.1),
    ("IS 2001", 03, 03.2),
    ("IS 2001", 03, 03.3),
    ("IS 2002", 01, 01.1),
    ("IS 2002", 01, 01.2),
    ("IS 2002", 01, 01.3),
    ("IS 2002", 02, 02.1),
    ("IS 2002", 02, 02.2),
    ("IS 2002", 02, 02.3),
    ("IS 2002", 02, 02.4),
    ("IS 2002", 03, 03.1),
    ("IS 2002", 03, 03.2),
    ("IS 2002", 03, 03.3),
    ("IS 2003", 01, 01.1),
    ("IS 2003", 01, 01.2),
    ("IS 2003", 01, 01.3),
    ("IS 2003", 02, 02.1),
    ("IS 2003", 02, 02.2),
    ("IS 2003", 02, 02.3),
    ("IS 2003", 03, 03.1),
    ("IS 2003", 03, 03.2);
   
INSERT INTO CourseSubTopicSlide (course_code, topic_id, sub_topic_id) VALUES
    ("CS 2001", 01, 01.1),
    ("CS 2001", 01, 01.2),
    ("CS 2001", 01, 01.3),
    ("CS 2001", 01, 01.4),
    ("CS 2001", 02, 02.1),
    ("CS 2001", 02, 02.2),
    ("CS 2001", 02, 02.3),
    ("CS 2001", 03, 03.1),
    ("CS 2001", 03, 03.2),
    ("CS 2001", 03, 03.3),
    ("CS 2002", 01, 01.1),
    ("CS 2002", 01, 01.2),
    ("CS 2002", 01, 01.3),
    ("CS 2002", 02, 02.1),
    ("CS 2002", 02, 02.2),
    ("CS 2002", 02, 02.3),
    ("CS 2002", 03, 03.1),
    ("CS 2002", 03, 03.2),
    ("CS 2002", 03, 03.3),
    ("CS 2002", 03, 03.4),
    ("CS 2003", 01, 01.1),
    ("CS 2003", 01, 01.2),
    ("CS 2003", 01, 01.3),
    ("CS 2003", 02, 02.1),
    ("CS 2003", 02, 02.2),
    ("CS 2003", 02, 02.3),
    ("CS 2003", 03, 03.1),
    ("CS 2003", 03, 03.2),
    ("CS 2003", 03, 03.3),
    ("CS 2004", 01, 01.1),
    ("CS 2004", 01, 01.2),
    ("CS 2004", 02, 02.1),
    ("CS 2004", 02, 02.2),
    ("CS 2004", 02, 02.3),
    ("CS 2004", 03, 03.1),
    ("CS 2004", 03, 03.2),
    ("CS 2004", 03, 03.3),
    ("IS 2001", 01, 01.1),
    ("IS 2001", 01, 01.2),
    ("IS 2001", 01, 01.3),
    ("IS 2001", 02, 02.1),
    ("IS 2001", 02, 02.2),
    ("IS 2001", 02, 02.3),
    ("IS 2001", 03, 03.1),
    ("IS 2001", 03, 03.2),
    ("IS 2001", 03, 03.3),
    ("IS 2002", 01, 01.1),
    ("IS 2002", 01, 01.2),
    ("IS 2002", 01, 01.3),
    ("IS 2002", 02, 02.1),
    ("IS 2002", 02, 02.2),
    ("IS 2002", 02, 02.3),
    ("IS 2002", 02, 02.4),
    ("IS 2002", 03, 03.1),
    ("IS 2002", 03, 03.2),
    ("IS 2002", 03, 03.3),
    ("IS 2003", 01, 01.1),
    ("IS 2003", 01, 01.2),
    ("IS 2003", 01, 01.3),
    ("IS 2003", 02, 02.1),
    ("IS 2003", 02, 02.2),
    ("IS 2003", 02, 02.3),
    ("IS 2003", 03, 03.1),
    ("IS 2003", 03, 03.2);
 
INSERT INTO CourseSubmission (course_code, submission_id, topic, description, allocated_mark, allocated_point, due_date, visibility) VALUES
    ("CS 2001", "1C01", "Creating a Database", "Create EER digram, mapping and MySQL database for the given scenario", 100, 10, "2022-12-24", 1),
    ("CS 2002", "1C02", "Assessment 01", "Inclass Quiz", 100, 10, "2023-02-24", 0),
    ("CS 2003", "1C03", "Assignment 01", "Write algorithms to implement given structures", 60, 6, "2023-01-15", 1),
    ("CS 2003", "2C03", "Assigment 02 - Question Paper", "Answer the questions and upload your answer sheets", 40, 4, "2022-12-18", 1),
    ("CS 2004", "1C04", "Assessment 01", "Implement suitable sorting algorithms for given instances", 50, 5, "2023-02-28", 0),
    ("CS 2004", "2C04", "Complexity Analysis", "Analyse the complexity of given algorithms", 50, 5, "2022-12-12", 1),
    ("IS 2001", "1I01", "Assignment", "Write C codes to implement the given algorithms", 100, 10, "2022-12-28", 1),
    ("IS 2002", "1I02", "Assignment - RAD", "Create a single page application usign MERN stack", 100, 10, "2023-01-20", 1),
    ("IS 2003", "1I03", "Practical Assessment", "Execute given instructions on your Linux machine and submit a document with screenshots.", 60, 6, "2023-01-10", 0),
    ("IS 2003", "2I03", "Assessment 02", "Create the given document usign LaTeX", 40, 4, "2022-12-20", 1);
   
DROP TABLE IF EXISTS KanbanTask;
CREATE TABLE KanbanTask (
    task_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(300),
    due_date DATETIME,
    state ENUM ("To Do", "In Progress", "Done") NOT NULL DEFAULT "To Do",
    stu_reg_no VARCHAR(12),
    lec_reg_no VARCHAR(12),
    CONSTRAINT PK_KanbanTask PRIMARY KEY (task_id),
    CONSTRAINT FK_KanbanTask_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_KanbanTask_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
INSERT INTO KanbanTask (task_id, title, description, due_date, state, stu_reg_no, lec_reg_no) VALUES
    ("Complete Database Note", "Complete database note together with diagrams and codes", "2022-12-10", 1, "2020/CS/0011", NULL),
    ("Create login", "Finish login and authentication module", "2022-12-20", 2, "2020/CS/0044", NULL),
    ("Update Slides", "Update data structures lecture slides", "2023-01-01", 1, NULL, "2003/LC/0004"),
    ("Assignment marks", "Correct 1st year assignments and upload marks", "2022-11-30", 3, NULL, "2018/LC/0022"),
    ("IEEE Script", "IEEE script review with the committee members", "2022-12-21", 1, "2020/IS/0032", NULL),
    ("Read!", "Algorithms resource book page 154-170", "2022-12-03", 2, "2020/CS/0026", NULL);

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
    heading VARCHAR(50) NOT NULL,
    content VARCHAR(300) NOT NULL,
    date DATETIME NOT NULL,
    admin_reg_no VARCHAR(12),
    cord_reg_no VARCHAR(12),
    CONSTRAINT PK_SiteAnnouncement PRIMARY KEY (announcement_id),
    CONSTRAINT FK_SiteAnnouncement_Admin FOREIGN KEY (admin_reg_no) REFERENCES Admin(reg_no),
    CONSTRAINT FK_SiteAnnouncement_AcademicStaff FOREIGN KEY (cord_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
DROP TABLE IF EXISTS CourseAnnouncement;
CREATE TABLE CourseAnnouncement (
    announcement_id INT NOT NULL AUTO_INCREMENT,
    heading VARCHAR(50) NOT NULL,
    content VARCHAR(300) NOT NULL,
    date DATETIME NOT NULL,
    lec_reg_no VARCHAR(12),
    course_code VARCHAR(8),
    CONSTRAINT PK_CourseAnnouncement PRIMARY KEY (announcement_id),
    CONSTRAINT FK_CourseAnnouncement_Course FOREIGN KEY (course_code) REFERENCES Course(course_code),
    CONSTRAINT FK_CourseAnnouncement_AcademicStaff FOREIGN KEY (lec_reg_no) REFERENCES AcademicStaff(reg_no)
);
 
DROP TABLE IF EXISTS PerformanceHistory;
CREATE TABLE PerformanceHistory (
    date_time DATETIME NOT NULL,
    cpu_usage VARCHAR(6),
    ram_usage VARCHAR(6),
    storage_usage VARCHAR(6),
    concurrent_users VARCHAR(6),
    CONSTRAINT PK_PerformanceHistory PRIMARY KEY (date_time)
);
 
DROP TABLE IF EXISTS AdminReport;
CREATE TABLE AdminReport (
    report_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    date_time DATETIME NOT NULL,
    CONSTRAINT PK_AdminReport PRIMARY KEY (report_id),
    CONSTRAINT FK_AdminReport_PerformanceHistory FOREIGN KEY (date_time) REFERENCES PerformanceHistory(date_time)
);
 
DROP TABLE IF EXISTS AttendanceReport;
CREATE TABLE AttendanceReport (
    report_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    report_date DATETIME NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    CONSTRAINT PK_AttendanceReport PRIMARY KEY (report_id, course_code),
    CONSTRAINT FK_AttendanceReport_Course FOREIGN KEY (course_code) REFERENCES Course(course_code)
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
    sub_topic_id DECIMAL(3,3) NOT NULL,
    is_completed BOOLEAN,
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

INSERT INTO LecCourse (lec_reg_no, course_code) VALUES
    ("2014/LC/0034", "CS 2001"),
    ("2014/LC/0034", "IS 2002"),
    ("2006/LC/0014", "CS 2002"),
    ("2018/LC/0022", "CS 2003"),
    ("2018/LC/0022", "IS 2001"),
    ("2003/LC/0004", "CS 2004"),
    ("2003/LC/0004", "CS 2003"),
    ("1999/LC/0008", "IS 2001"),
    ("2016/LC/0015", "IS 2002"),
    ("1998/LC/0019", "IS 2003");
 
DROP TABLE IF EXISTS StuCourseSubmission;
CREATE TABLE StuCourseSubmission (
    stu_reg_no VARCHAR(12) NOT NULL,
    course_code VARCHAR(8) NOT NULL,
    submission_id VARCHAR(4) NOT NULL,
    stu_submission_point INT,
    stu_submission_mark INT,
    state ENUM ("To Do", "In Progress", "Done") NOT NULL DEFAULT "To Do",
    CONSTRAINT PK_StuCourseSubmission PRIMARY KEY (stu_reg_no, course_code, submission_id),
    CONSTRAINT FK_StuCourseSubmission_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no),
    CONSTRAINT FK_StuCourseSubmission_CourseSubmission FOREIGN KEY (course_code, submission_id) REFERENCES CourseSubmission(course_code, submission_id)
);
 
