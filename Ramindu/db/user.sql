DROP DATABASE IF EXISTS `ramindu_lambda`;
CREATE DATABASE `ramindu_lambda`;

USE `ramindu_lambda`;

DROP TABLE IF EXISTS Users;
CREATE TABLE Users(
                      reg_no VARCHAR(12) NOT NULL,
                      f_name varchar(50) NOT NULL,
                      l_name varchar(50) NOT NULL,
                      email varchar(50) NOT NULL,
                      password varchar(50) NOT NULL,
                      contact_no varchar(13),
                      active_status int NOT NULL,
                      login_date_time datetime, -- TODO: REFACTOR TO lastLogin
                      logout_date_time datetime,
                      CONSTRAINT pk_user PRIMARY KEY (reg_no)
);


INSERT INTO Users (reg_no, f_name, l_name, email, password, contact_no, active_status)
VALUES ('2020/LC/1234', 'John', 'Doe', 'john@gmail.com', '1234', '0712345678', 0);

DROP TABLE IF EXISTS Courses;
CREATE TABLE Courses(
                        course_code varchar(7)  NOT NULL,
                        course_name varchar(50) NOT NULL,
                        CONSTRAINT pk_course PRIMARY KEY (course_code)
);

INSERT INTO Courses (course_code, course_name) VALUES ('SCS2201', 'Data Strcutuers and Algorithms');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2203', 'Software Engineering III');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2204', 'Functional Programming');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2205', 'Computer Networks I');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2206', 'Mathematical Methods II');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2207', 'Programming Language Concepts');
INSERT INTO Courses (course_code, course_name) VALUES ('SCS2208', 'Rapid Application Development');
