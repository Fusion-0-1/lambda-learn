CREATE DATABASE inuri_lambda;

USE inuri_lambda;

CREATE TABLE login (
    User_ID varchar(10),
    Username varchar(100),
    Password varchar(100),
    PRIMARY KEY (User_ID)
);

CREATE TABLE student (
   name varchar(100),
   index_no int,
   reg_no varchar(12),
   email varchar(200),
   contact_no varchar(20),
   personal_email varchar(200),
   password varchar(100),
   degree_programme varchar(100),
   PRIMARY KEY (reg_no)
);

INSERT INTO `login`(`User_ID`, `Username`, `Password`) VALUES ('ad001','Inuri_Lavanya','20000715');
INSERT INTO `login`(`User_ID`, `Username`, `Password`) VALUES ('ad002','Lavanya','071');

INSERT INTO `student`(`name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Inuri Lavanya','20000715','2020/cs/071','inuri@ms.ac.lk','0713465234','inuri@gmail.com','inuri','computer science');
INSERT INTO `student`(`name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Dilanga Harshani','20000723','2020/cs/072','dilanga@ms.ac.lk','0753465234','dilanga@gmail.com','dilanga','computer science');
INSERT INTO `student`(`name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Ramindu Walgama','20000735','2020/cs/073','ramindu@ms.ac.lk','0713495234','ramindu@gmail.com','ramindu','computer science');
INSERT INTO `student`(`name`, `index_no`, `reg_no`, `email`, `contact_no`, `personal_email`, `password`, `degree_programme`) VALUES ('Anjana Silva','20000746','2020/cs/074','anjana@ms.ac.lk','0753405234','anjana@gmail.com','anjana','computer science');