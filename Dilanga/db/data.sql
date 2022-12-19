DROP DATABASE IF EXISTS `lambda_dh`;
CREATE DATABASE `lambda_dh`;
 
USE `lambda_dh`;
 
DROP TABLE IF EXISTS Student;
CREATE TABLE Student (
    reg_no VARCHAR(12) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    contact_no VARCHAR(12),
    password VARCHAR(60) NOT NULL,
    date_joined DATE NOT NULL,
    CONSTRAINT PK_Student PRIMARY KEY (reg_no)
);

DROP TABLE IF EXISTS KanbanTask;
CREATE TABLE KanbanTask (
    task_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(300),
    due_date DATE,
    state ENUM ("To Do", "In Progress", "Done") NOT NULL DEFAULT "To Do",
    stu_reg_no VARCHAR(12),
    CONSTRAINT PK_KanbanTask PRIMARY KEY (task_id),
    CONSTRAINT FK_KanbanTask_Student FOREIGN KEY (stu_reg_no) REFERENCES Student(reg_no)
);

INSERT INTO Student (reg_no, first_name, last_name, email, contact_no, password, date_joined) VALUES
    ("2020CS0011", "Dilanga", "Harshani", "2020cs0011@fusion.ac.lk", "772267962", "20000011@CS", "2021-02-24"),
    ("2020CS0014", "Inuri", "Lavanya", "2020cs0014@fusion.ac.lk", "719267365", "20000014@CS", "2021-02-24"),
    ("2020CS0026", "Ramindu", "Walgama", "2020cs0016@fusion.ac.lk", "712028360", "20000026@CS", "2021-02-24"),
    ("2020CS0044", "Anjana", "Silva", "2020cs0044@fusion.ac.lk", "720261354", "20000044@CS", "2021-02-24"),
    ("2020IS0016", "Ravin", "Dias", "2020is0016@fusion.ac.lk", "762349367", "21000016@CS", "2021-02-24"),
    ("2020IS0032", "Aruni", "Samara", "2020is0032@fusion.ac.lk", "742934349", "21000032@CS", "2021-02-24"),        
    ("2020IS0051", "Kavindu", "Fernando", "2020is0051@fusion.ac.lk", "752678334", "21000051@CS", "2021-02-24"),
    ("2020IS0075", "Malsha", "Kavindi", "2020is0075@fusion.ac.lk", "782025393", "21000075@CS", "2021-02-24");

INSERT INTO KanbanTask (title, description, due_date, state) VALUES
    ("Complete Database Note", "Complete database note together with diagrams and codes", "2022-12-10", 1),
    ("Create login", "Finish login and authentication module", "2022-12-20", 2),
    ("Update Slides", "Update data structures lecture slides", "2023-01-01", 1),
    ("Assignment marks", "Correct 1st year assignments and upload marks", "2022-11-30", 3),
    ("IEEE Script", "IEEE script review with the committee members", "2022-12-21", 1),
    ("Read!", "Algorithms resource book page 154-170", "2022-12-03", 2);