CREATE DATABASE inuri_lambda;

USE inuri_lambda;

CREATE TABLE login (
    Username varchar(100),
    Name varchar(200),
    Password varchar(100),
    PRIMARY KEY (Username)
);

CREATE TABLE student (
   f_name varchar(100),
   l_name varchar(100),
   index_no int,
   reg_no varchar(12),
   email varchar(200),
   contact_no varchar(20),
   personal_email varchar(200),
   password varchar(100),
   degree_programme varchar(100),
   PRIMARY KEY (reg_no)
);

INSERT INTO `login`( `Username`, `Name`, `Password`) VALUES ('2018/AD/0012', 'A.B.C. Perera','ad@12');
INSERT INTO `login`(`Username`, `Name`, `Password`) VALUES ('2018/AD/0001', 'C.D. Gamage','ad@01');

INSERT INTO `student`(`f_name`,`l_name` , `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Inuri','Lavanya','20000715','2020/cs/071','inuri@ms.ac.lk','0713465234','inuri@gmail.com','inuri','computer science');
INSERT INTO `student`(`f_name`,`l_name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Dilanga', 'Harshani','20000723','2020/cs/072','dilanga@ms.ac.lk','0753465234','dilanga@gmail.com','dilanga','computer science');
INSERT INTO `student`(`f_name`,`l_name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Ramindu', 'Walgama','20000735','2020/cs/073','ramindu@ms.ac.lk','0713495234','ramindu@gmail.com','ramindu','computer science');
INSERT INTO `student`(`f_name`,`l_name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Anjana', 'Silva','20000746','2020/cs/074','anjana@ms.ac.lk','0753405234','anjana@gmail.com','anjana','computer science');