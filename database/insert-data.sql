
USE `lambda-learn`;

INSERT INTO Student (reg_no, first_name, last_name, email, personal_email, contact_no, password, index_no, date_joined, degree_program_code) VALUES
    ("2020/CS/0011", "Dilanga", "Harshani", "2020cs0011@fusion.ac.lk", "aadilanga@gmail.com", "772267962", "$2y$10$xBdAZCP3TDyMl2etzDcTxOWHiMJSTjPnV5sdHC6iVef9YQSnr/51.", 20000011, "2021-02-24", "CS"),
    ("2020/CS/0014", "Inuri", "Lavanya", "2020cs0014@fusion.ac.lk", "inurilavanya@gmail.com", "719267365", "$2y$10$Kbc/hlAD4aAKdiJlkHNDAOpkJ5vvJ/j2hRdCkXrC1sJDeUx4yGueq", 20000014, "2021-02-24", "CS"),
    ("2020/CS/0026", "Ramindu", "Walgama", "2020cs0016@fusion.ac.lk", "rrwalgama2@gmail.com", "712028360", "$2y$10$OY8lGr87I3XZ9XxJq7LpwOP5PNOmA7OaFMKy424tSIr8Hi7duDYdy", 20000026, "2021-02-24", "CS"),
    ("2020/CS/0044", "Anjana", "Silva", "2020cs0044@fusion.ac.lk", "anjana1.silva@gmail.com", "720261354", "$2y$10$1vlvhhsYikj7OUF01WPUd.VJSf7CTaCaisBs0KRCjZCix6zYr6rWK", 20000044, "2021-02-24", "CS"),
    ("2020/IS/0016", "Ravin", "Dias", "2020is0016@fusion.ac.lk", "naravindias2510@gmail.com", "762349367", "21000016@CS", 21000016, "2021-02-24", "IS"),
    ("2020/IS/0032", "Aruni", "Samara", "2020is0032@fusion.ac.lk", "aruniisamaraa@gmail.com", "742934349", "21000032@CS", 21000032, "2021-02-24", "IS"),        
    ("2020/IS/0051", "Kavindu", "Fernando", "2020is0051@fusion.ac.lk", "fernandok@gmail.com", "752678334", "21000051@CS", 21000051, "2021-02-24", "IS"),
    ("2020/IS/0075", "Malsha", "Kavindi", "2020is0075@fusion.ac.lk", "malsha.kavi@gmail.com", "782025393", "21000075@CS", 21000075, "2021-02-24", "IS");

INSERT INTO AcademicStaff (reg_no, first_name, last_name, email, contact_no, password, position) VALUES
    ("2014/LC/0034", "Erandi", "Gamage", "2014lc0034@fusion.ac.lk", "772469621", "$2y$10$fJJYYm4dcPVD6u/3aPgbP.0A2fx7u8E39j9NdBxaAi8AGOBz/RoHq", "Senior Lecturer"),    
    ("2008/LC/0002", "Naresh", "Rajan", "2008lc0002@fusion.ac.lk", "746682736", "20080002@LC", "Lecturer"),
    ("2006/LC/0014", "Janani", "Walpola", "2006lc0014@fusion.ac.lk", "753028364", "20060014@LC", "Lecturer"),
    ("2018/LC/0022", "Tissa", "Silva", "2018lc0022@fusion.ac.lk", "764861337", "$2y$10$s4kAAMw/JInG7gBYcf.TFejBZpantRRh7hq/U12XnkqieJRx269dy", "Professor"),
    ("2003/LC/0004", "Manoj", "Fernando", "2003lc0004@fusion.ac.lk", "742335368", "$2y$10$eMkJfs5mM7MMFS3fLpv/peLGCcjEQiFBdIF9cGJdqZH9Ta/F1I6ou", "Professor"),
    ("1999/LC/0008", "Mohomad", "Abdullah", "1999lc0008@fusion.ac.lk", "716934345", "19990008@LC", "Senior Lecturer"),        
    ("2016/LC/0015", "Kamani", "Perera", "2016lc0015@fusion.ac.lk", "752345331", "20160015@LC", "Senior Professor"),
    ("2020/LC/0026", "Ramindu", "Walgama", "2020lc0026@fusion.ac.lk", "716461434", "$2y$10$4z8Q1Gu8TeXp45Ou/zpdxeef2Wf8LEdjUZi.XifgLBGjQhgjf02CG", "Senior Professor"),
    ("1998/LC/0019", "Sandya", "Kumari", "1998lc0019@fusion.ac.lk", "782645352", "19980019@LC", "Lecturer");

UPDATE AcademicStaff SET degree_program_code = "CS" WHERE reg_no = "2003/LC/0004";
UPDATE AcademicStaff SET degree_program_code = "IS" WHERE reg_no = "1998/LC/0019";

INSERT INTO Admin (reg_no, first_name, last_name, email, contact_no, password) VALUES
    ("2020/AD/0026", "Ramindu", "Walgama", "2020ad0026@fusion.ac.lk", "716461434", "$2y$10$4z8Q1Gu8TeXp45Ou/zpdxeef2Wf8LEdjUZi.XifgLBGjQhgjf02CG"),
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
    ("CS 2001", 01, 1.01, "Hierarchical Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.02, "Network Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.03, "Relational Model", 1, "2014/LC/0034"),
    ("CS 2001", 01, 1.04, "Object Relational Model", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.01, "Normalization", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.02, "Cardinality and Participation", 1, "2014/LC/0034"),
    ("CS 2001", 02, 2.03, "ER & EER Diagrams", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.01, "Query Languages", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.02, "MySQL CRUD Operations", 1, "2014/LC/0034"),
    ("CS 2001", 03, 3.03, "MySQL Joins", 1, "2014/LC/0034"),
    ("CS 2002", 01, 1.01, "Prepositional Logic", 1, "2006/LC/0014"),
    ("CS 2002", 01, 1.02, "Predicate Logic", 1, "2006/LC/0014"),
    ("CS 2002", 01, 1.03, "Arguments", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.01, "Set Notation", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.02, "Set Thoeries", 1, "2006/LC/0014"),
    ("CS 2002", 02, 2.03, "Solving Problems using Sets", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.01, "Functions", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.02, "Binary Relations", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.03, "Equivalance Relations", 1, "2006/LC/0014"),
    ("CS 2002", 03, 3.04, "Partial Order Relations", 1, "2006/LC/0014"),
    ("CS 2003", 01, 1.01, "Introduction to Stacks", 1, "2018/LC/0022"),
    ("CS 2003", 01, 1.02, "Implementing a Stack", 1, "2018/LC/0022"),
    ("CS 2003", 01, 1.03, "Adding & Deleting Data", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.01, "Introduction to Queues", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.02, "Implementing a Queue", 1, "2018/LC/0022"),
    ("CS 2003", 02, 2.03, "Adding & Deleting Data", 1, "2018/LC/0022"),
    ("CS 2003", 03, 3.01, "Introduction to Linked Lists", 1, "2003/LC/0004"),
    ("CS 2003", 03, 3.02, "Implementing a Linked List", 1, "2003/LC/0004"),
    ("CS 2003", 03, 3.03, "Adding & Deleting Nodes", 1, "2003/LC/0004"),
    ("CS 2004", 01, 1.01, "Algorithms", 1, "2003/LC/0004"),
    ("CS 2004", 01, 1.02, "Analysing Algorithms", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.01, "Big O Notation", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.02, "Big Omega Notation", 1, "2003/LC/0004"),
    ("CS 2004", 02, 2.03, "Big Theta Notation", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.01, "Bubble Sort", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.02, "Insertion Sort", 1, "2003/LC/0004"),
    ("CS 2004", 03, 3.03, "Selection Sort", 1, "2003/LC/0004"),
    ("IS 2001", 01, 1.01, "History of C Language", 1, "2018/LC/0022"),
    ("IS 2001", 01, 1.02, "Basic Syntax", 1, "2018/LC/0022"),
    ("IS 2001", 01, 1.03, "C Libraries", 1, "2018/LC/0022"),
    ("IS 2001", 02, 2.01, "Sequence", 1, "1999/LC/0008"),
    ("IS 2001", 02, 2.02, "Selection", 1, "1999/LC/0008"),
    ("IS 2001", 02, 2.03, "Iteration", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.01, "Stacks using C", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.02, "Queues using C", 1, "1999/LC/0008"),
    ("IS 2001", 03, 3.03, "Linked Lists using C", 1, "1999/LC/0008"),
    ("IS 2002", 01, 1.01, "History of RAD", 1, "2014/LC/0034"),
    ("IS 2002", 01, 1.02, "Principles of RAD", 1, "2014/LC/0034"),
    ("IS 2002", 01, 1.03, "JavaScript", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.01, "Mongo DB", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.02, "Express JS", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.03, "React JS", 1, "2016/LC/0015"),
    ("IS 2002", 02, 2.04, "Node JS", 1, "2016/LC/0015"),
    ("IS 2002", 03, 3.01, "Agile Principles", 1, "2014/LC/0034"),
    ("IS 2002", 03, 3.02, "Agile Practices", 1, "2014/LC/0034"),
    ("IS 2002", 03, 3.03, "Agile Testing", 1, "2014/LC/0034"),
    ("IS 2003", 01, 1.01, "History of Linux", 1, "1998/LC/0019"),
    ("IS 2003", 01, 1.02, "Linux Distributions", 1, "1998/LC/0019"),
    ("IS 2003", 01, 1.03, "Installation", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.01, "VIM Editor", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.02, "Nano Editor", 1, "1998/LC/0019"),
    ("IS 2003", 02, 2.03, "LaTeX", 1, "1998/LC/0019"),
    ("IS 2003", 03, 3.01, "Libre Office", 1, "1998/LC/0019"),
    ("IS 2003", 03, 3.02, "GIMP", 1, "1998/LC/0019");
 
INSERT INTO CourseSubTopicRec (course_code, topic_id, sub_topic_id, recording) VALUES
    ("CS 2001", 01, 1.01, "path/recording.mp4"),
    ("CS 2001", 01, 1.02, "path/recording.mp4"),
    ("CS 2001", 01, 1.03, "path/recording.mp4"),
    ("CS 2001", 01, 1.04, "path/recording.mp4"),
    ("CS 2001", 02, 2.01, "path/recording.mp4"),
    ("CS 2001", 02, 2.02, "path/recording.mp4"),
    ("CS 2001", 02, 2.03, "path/recording.mp4"),
    ("CS 2001", 03, 3.01, "path/recording.mp4"),
    ("CS 2001", 03, 3.02, "path/recording.mp4"),
    ("CS 2001", 03, 3.03, "path/recording.mp4"),
    ("CS 2002", 01, 1.01, "path/recording.mp4"),
    ("CS 2002", 01, 1.02, "path/recording.mp4"),
    ("CS 2002", 01, 1.03, "path/recording.mp4"),
    ("CS 2002", 02, 2.01, "path/recording.mp4"),
    ("CS 2002", 02, 2.02, "path/recording.mp4"),
    ("CS 2002", 02, 2.03, "path/recording.mp4"),
    ("CS 2002", 03, 3.01, "path/recording.mp4"),
    ("CS 2002", 03, 3.02, "path/recording.mp4"),
    ("CS 2002", 03, 3.03, "path/recording.mp4"),
    ("CS 2002", 03, 3.04, "path/recording.mp4"),
    ("CS 2003", 01, 1.01, "path/recording.mp4"),
    ("CS 2003", 01, 1.02, "path/recording.mp4"),
    ("CS 2003", 01, 1.03, "path/recording.mp4"),
    ("CS 2003", 02, 2.01, "path/recording.mp4"),
    ("CS 2003", 02, 2.02, "path/recording.mp4"),
    ("CS 2003", 02, 2.03, "path/recording.mp4"),
    ("CS 2003", 03, 3.01, "path/recording.mp4"),
    ("CS 2003", 03, 3.02, "path/recording.mp4"),
    ("CS 2003", 03, 3.03, "path/recording.mp4"),
    ("CS 2004", 01, 1.01, "path/recording.mp4"),
    ("CS 2004", 01, 1.02, "path/recording.mp4"),
    ("CS 2004", 02, 2.01, "path/recording.mp4"),
    ("CS 2004", 02, 2.02, "path/recording.mp4"),
    ("CS 2004", 02, 2.03, "path/recording.mp4"),
    ("CS 2004", 03, 3.01, "path/recording.mp4"),
    ("CS 2004", 03, 3.02, "path/recording.mp4"),
    ("CS 2004", 03, 3.03, "path/recording.mp4"),
    ("IS 2001", 01, 1.01, "path/recording.mp4"),
    ("IS 2001", 01, 1.02, "path/recording.mp4"),
    ("IS 2001", 01, 1.03, "path/recording.mp4"),
    ("IS 2001", 02, 2.01, "path/recording.mp4"),
    ("IS 2001", 02, 2.02, "path/recording.mp4"),
    ("IS 2001", 02, 2.03, "path/recording.mp4"),
    ("IS 2001", 03, 3.01, "path/recording.mp4"),
    ("IS 2001", 03, 3.02, "path/recording.mp4"),
    ("IS 2001", 03, 3.03, "path/recording.mp4"),
    ("IS 2002", 01, 1.01, "path/recording.mp4"),
    ("IS 2002", 01, 1.02, "path/recording.mp4"),
    ("IS 2002", 01, 1.03, "path/recording.mp4"),
    ("IS 2002", 02, 2.01, "path/recording.mp4"),
    ("IS 2002", 02, 2.02, "path/recording.mp4"),
    ("IS 2002", 02, 2.03, "path/recording.mp4"),
    ("IS 2002", 02, 2.04, "path/recording.mp4"),
    ("IS 2002", 03, 3.01, "path/recording.mp4"),
    ("IS 2002", 03, 3.02, "path/recording.mp4"),
    ("IS 2002", 03, 3.03, "path/recording.mp4"),
    ("IS 2003", 01, 1.01, "path/recording.mp4"),
    ("IS 2003", 01, 1.02, "path/recording.mp4"),
    ("IS 2003", 01, 1.03, "path/recording.mp4"),
    ("IS 2003", 02, 2.01, "path/recording.mp4"),
    ("IS 2003", 02, 2.02, "path/recording.mp4"),
    ("IS 2003", 02, 2.03, "path/recording.mp4"),
    ("IS 2003", 03, 3.01, "path/recording.mp4"),
    ("IS 2003", 03, 3.02, "path/recording.mp4");
   
INSERT INTO CourseSubTopicSlide (course_code, topic_id, sub_topic_id, slide) VALUES
    ("CS 2001", 01, 1.01, "path/slides.pdf"),
    ("CS 2001", 01, 1.02, "path/slides.pdf"),
    ("CS 2001", 01, 1.03, "path/slides.pdf"),
    ("CS 2001", 01, 1.04, "path/slides.pdf"),
    ("CS 2001", 02, 2.01, "path/slides.pdf"),
    ("CS 2001", 02, 2.02, "path/slides.pdf"),
    ("CS 2001", 02, 2.03, "path/slides.pdf"),
    ("CS 2001", 03, 3.01, "path/slides.pdf"),
    ("CS 2001", 03, 3.02, "path/slides.pdf"),
    ("CS 2001", 03, 3.03, "path/slides.pdf"),
    ("CS 2002", 01, 1.01, "path/slides.pdf"),
    ("CS 2002", 01, 1.02, "path/slides.pdf"),
    ("CS 2002", 01, 1.03, "path/slides.pdf"),
    ("CS 2002", 02, 2.01, "path/slides.pdf"),
    ("CS 2002", 02, 2.02, "path/slides.pdf"),
    ("CS 2002", 02, 2.03, "path/slides.pdf"),
    ("CS 2002", 03, 3.01, "path/slides.pdf"),
    ("CS 2002", 03, 3.02, "path/slides.pdf"),
    ("CS 2002", 03, 3.03, "path/slides.pdf"),
    ("CS 2002", 03, 3.04, "path/slides.pdf"),
    ("CS 2003", 01, 1.01, "path/slides.pdf"),
    ("CS 2003", 01, 1.02, "path/slides.pdf"),
    ("CS 2003", 01, 1.03, "path/slides.pdf"),
    ("CS 2003", 02, 2.01, "path/slides.pdf"),
    ("CS 2003", 02, 2.02, "path/slides.pdf"),
    ("CS 2003", 02, 2.03, "path/slides.pdf"),
    ("CS 2003", 03, 3.01, "path/slides.pdf"),
    ("CS 2003", 03, 3.02, "path/slides.pdf"),
    ("CS 2003", 03, 3.03, "path/slides.pdf"),
    ("CS 2004", 01, 1.01, "path/slides.pdf"),
    ("CS 2004", 01, 1.02, "path/slides.pdf"),
    ("CS 2004", 02, 2.01, "path/slides.pdf"),
    ("CS 2004", 02, 2.02, "path/slides.pdf"),
    ("CS 2004", 02, 2.03, "path/slides.pdf"),
    ("CS 2004", 03, 3.01, "path/slides.pdf"),
    ("CS 2004", 03, 3.02, "path/slides.pdf"),
    ("CS 2004", 03, 3.03, "path/slides.pdf"),
    ("IS 2001", 01, 1.01, "path/slides.pdf"),
    ("IS 2001", 01, 1.02, "path/slides.pdf"),
    ("IS 2001", 01, 1.03, "path/slides.pdf"),
    ("IS 2001", 02, 2.01, "path/slides.pdf"),
    ("IS 2001", 02, 2.02, "path/slides.pdf"),
    ("IS 2001", 02, 2.03, "path/slides.pdf"),
    ("IS 2001", 03, 3.01, "path/slides.pdf"),
    ("IS 2001", 03, 3.02, "path/slides.pdf"),
    ("IS 2001", 03, 3.03, "path/slides.pdf"),
    ("IS 2002", 01, 1.01, "path/slides.pdf"),
    ("IS 2002", 01, 1.02, "path/slides.pdf"),
    ("IS 2002", 01, 1.03, "path/slides.pdf"),
    ("IS 2002", 02, 2.01, "path/slides.pdf"),
    ("IS 2002", 02, 2.02, "path/slides.pdf"),
    ("IS 2002", 02, 2.03, "path/slides.pdf"),
    ("IS 2002", 02, 2.04, "path/slides.pdf"),
    ("IS 2002", 03, 3.01, "path/slides.pdf"),
    ("IS 2002", 03, 3.02, "path/slides.pdf"),
    ("IS 2002", 03, 3.03, "path/slides.pdf"),
    ("IS 2003", 01, 1.01, "path/slides.pdf"),
    ("IS 2003", 01, 1.02, "path/slides.pdf"),
    ("IS 2003", 01, 1.03, "path/slides.pdf"),
    ("IS 2003", 02, 2.01, "path/slides.pdf"),
    ("IS 2003", 02, 2.02, "path/slides.pdf"),
    ("IS 2003", 02, 2.03, "path/slides.pdf"),
    ("IS 2003", 03, 3.01, "path/slides.pdf"),
    ("IS 2003", 03, 3.02, "path/slides.pdf");
 
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
 
INSERT INTO KanbanTask (title, description, due_date, state, stu_reg_no, lec_reg_no) VALUES
    ("Complete Database Note", "Complete database note together with diagrams and codes", "2022-12-10", 1, "2020/CS/0011", NULL),
    ("Create login", "Finish login and authentication module", "2022-12-20", 2, "2020/CS/0044", NULL),
    ("Update Slides", "Update data structures lecture slides", "2023-01-01", 1, NULL, "2003/LC/0004"),
    ("Assignment marks", "Correct 1st year assignments and upload marks", "2022-11-30", 3, NULL, "2018/LC/0022"),
    ("IEEE Script", "IEEE script review with the committee members", "2022-12-21", 1, "2020/IS/0032", NULL),
    ("Read!", "Algorithms resource book page 154-170", "2022-12-03", 2, "2020/CS/0026", NULL);

INSERT INTO TimeTableEvent (course_code, location, start_datetime, end_datetime, lec_reg_no) VALUES
    ("CS 2001", "A201", "2022-11-21 10:00:00", "2022-11-21 12:00:00", "2014/LC/0034"),
    ("CS 2002", "B203", "2022-11-21 08:00:00", "2022-11-21 10:00:00", "2006/LC/0014"),
    ("CS 2003", "A301", "2022-11-22 08:00:00", "2022-11-22 10:00:00", "2003/LC/0004"),
    ("CS 2003", "D102", "2022-11-22 13:00:00", "2022-11-22 15:00:00", "2018/LC/0022"),
    ("CS 2004", "A201", "2022-11-23 10:00:00", "2022-11-23 12:00:00", "2003/LC/0004"),
    ("IS 2001", "A301", "2022-11-23 13:00:00", "2022-11-23 15:00:00", "1999/LC/0008"),
    ("IS 2001", "B203", "2022-11-24 08:00:00", "2022-11-24 10:00:00", "2018/LC/0022"),
    ("IS 2002", "C101", "2022-11-24 13:00:00", "2022-11-24 15:00:00", "2014/LC/0034"),
    ("IS 2002", "C203", "2022-11-25 08:00:00", "2022-11-25 10:00:00", "2016/LC/0015"),
    ("IS 2003", "D102", "2022-11-25 13:00:00", "2022-11-25 17:00:00", "1998/LC/0019");
 
INSERT INTO SiteAnnouncement (heading, content, publish_date, admin_reg_no, cord_reg_no) VALUES
    ("Commencement of New Academic Year", "Academic year 2022/23 willl be commenced on 21st of November 2022", "2022-11-18", "2009/AD/0005", NULL),
    ("First year 2nd semester examination results", "Results of 2nd semester examination will be released in 2 weeks. Prepare your emotional support system :)", "2022-11-21", NULL, "2003/LC/0004");
 
INSERT INTO CourseAnnouncement (heading, content, publish_date, lec_reg_no, course_code) VALUES
    ("Lecture Materials", "New lecture materials are uploaded to the course page. Make sure to refer them before the lecture", "2022-11-21", "2014/LC/0034", "CS 2001"),
    ("Assessment", "There will be an inclass assessment based on prepositions and sets you learned. Date will be informed later.", "2022-11-23", "2006/LC/0014", "CS 2002"),
    ("Practical Session", "The lecture on 22nd will be conducted as a practical session. Bringing your laptops will be beneficial", "2022-11-19", "2018/LC/0022", "CS 2003"),
    ("Assessment 01", "Assessment 01 is now uploaded to the course page. Make sure to submit on or before deadline", "2022-11-25", "2003/LC/0004", "CS 2004"),
    ("Lecture Recordings", "New lecture recordings are uploaded to the course page for extra knowledge", "2022-11-22", "1999/LC/0008", "IS 2001"),
    ("References", "Reference book is now uploaded to the course page. Please read it before attending lectures", "2022-11-19", "2016/LC/0015", "IS 2002"),
    ("Cancellation of Lectures", "This week's lecture has to be cancelled due to unavoidable reasons. See you next week", "2022-11-24", "1998/LC/0019", "IS 2003");

INSERT INTO AttendanceReport (title, report_date, course_code) VALUES
    ("Attendance CS 2001 25/11", "2022-11-26", "CS 2001"),
    ("Attendance CS 2002 25/11", "2022-11-26", "CS 2002"),
    ("Attendance CS 2003 25/11", "2022-11-26", "CS 2003"),
    ("Attendance CS 2004 25/11", "2022-11-26", "CS 2004"),
    ("Attendance IS 2001 25/11", "2022-11-26", "IS 2001"),
    ("Attendance IS 2002 25/11", "2022-11-26", "IS 2002"),
    ("Attendance IS 2003 25/11", "2022-11-26", "IS 2003"),
    ("Attendance CS 2001 02/12", "2022-12-03", "CS 2001"),
    ("Attendance CS 2002 02/12", "2022-12-03", "CS 2002"),
    ("Attendance CS 2003 02/12", "2022-12-03", "CS 2003"),
    ("Attendance CS 2004 02/12", "2022-12-03", "CS 2004"),
    ("Attendance IS 2001 02/12", "2022-12-03", "IS 2001"),
    ("Attendance IS 2002 02/12", "2022-12-03", "IS 2002"),
    ("Attendance IS 2003 02/12", "2022-12-03", "IS 2003");

INSERT INTO ProgressReport (title, report_date, course_code) VALUES
    ("Progress CS 2001 25/11", "2022-11-26", "CS 2001"),
    ("Progress CS 2002 25/11", "2022-11-26", "CS 2002"),
    ("Progress CS 2003 25/11", "2022-11-26", "CS 2003"),
    ("Progress CS 2004 25/11", "2022-11-26", "CS 2004"),
    ("Progress IS 2001 25/11", "2022-11-26", "IS 2001"),
    ("Progress IS 2002 25/11", "2022-11-26", "IS 2002"),
    ("Progress IS 2003 25/11", "2022-11-26", "IS 2003"),
    ("Progress CS 2001 02/12", "2022-12-03", "CS 2001"),
    ("Progress CS 2002 02/12", "2022-12-03", "CS 2002"),
    ("Progress CS 2003 02/12", "2022-12-03", "CS 2003"),
    ("Progress CS 2004 02/12", "2022-12-03", "CS 2004"),
    ("Progress IS 2001 02/12", "2022-12-03", "IS 2001"),
    ("Progress IS 2002 02/12", "2022-12-03", "IS 2002"),
    ("Progress IS 2003 02/12", "2022-12-03", "IS 2003");

INSERT INTO StuTimeTableEvent (stu_reg_no, event_id) VALUES
    ("2020/CS/0011", 1),
    ("2020/CS/0011", 2),
    ("2020/CS/0011", 3),
    ("2020/CS/0011", 4),
    ("2020/CS/0011", 5),
    ("2020/CS/0014", 1),
    ("2020/CS/0014", 2),
    ("2020/CS/0014", 3),
    ("2020/CS/0014", 4),
    ("2020/CS/0014", 5),
    ("2020/CS/0026", 1),
    ("2020/CS/0026", 3),
    ("2020/CS/0026", 4),
    ("2020/CS/0026", 5),
    ("2020/CS/0044", 1),
    ("2020/CS/0044", 3),
    ("2020/CS/0044", 4),
    ("2020/CS/0044", 5),
    ("2020/IS/0016", 6),
    ("2020/IS/0016", 7),
    ("2020/IS/0016", 8),
    ("2020/IS/0016", 9),
    ("2020/IS/0016", 10),
    ("2020/IS/0032", 6),
    ("2020/IS/0032", 7),
    ("2020/IS/0032", 8),
    ("2020/IS/0032", 9),
    ("2020/IS/0032", 10),
    ("2020/IS/0051", 7),
    ("2020/IS/0051", 10),
    ("2020/IS/0075", 7),
    ("2020/IS/0075", 10);

INSERT INTO StuCourseSubTopic (stu_reg_no, course_code, topic_id, sub_topic_id) VALUES
    ("2020/CS/0011", "CS 2001", 01, 1.01),
    ("2020/CS/0011", "CS 2001", 01, 1.02),
    ("2020/CS/0011", "CS 2001", 01, 1.03),
    ("2020/CS/0011", "CS 2001", 01, 1.04),
    ("2020/CS/0011", "CS 2001", 02, 2.01),
    ("2020/CS/0011", "CS 2001", 02, 2.02),
    ("2020/CS/0011", "CS 2001", 02, 2.03),
    ("2020/CS/0011", "CS 2001", 03, 3.01),
    ("2020/CS/0011", "CS 2001", 03, 3.02),
    ("2020/CS/0011", "CS 2001", 03, 3.03),
    ("2020/CS/0011", "CS 2002", 01, 1.01),
    ("2020/CS/0011", "CS 2002", 01, 1.02),
    ("2020/CS/0011", "CS 2002", 01, 1.03),
    ("2020/CS/0011", "CS 2002", 02, 2.01),
    ("2020/CS/0011", "CS 2002", 02, 2.02),
    ("2020/CS/0011", "CS 2002", 02, 2.03),
    ("2020/CS/0011", "CS 2002", 03, 3.01),
    ("2020/CS/0011", "CS 2002", 03, 3.02),
    ("2020/CS/0011", "CS 2002", 03, 3.03),
    ("2020/CS/0011", "CS 2002", 03, 3.04),
    ("2020/CS/0011", "CS 2003", 01, 1.01),
    ("2020/CS/0011", "CS 2003", 01, 1.02),
    ("2020/CS/0011", "CS 2003", 01, 1.03),
    ("2020/CS/0011", "CS 2003", 02, 2.01),
    ("2020/CS/0011", "CS 2003", 02, 2.02),
    ("2020/CS/0011", "CS 2003", 02, 2.03),
    ("2020/CS/0011", "CS 2003", 03, 3.01),
    ("2020/CS/0011", "CS 2003", 03, 3.02),
    ("2020/CS/0011", "CS 2003", 03, 3.03),
    ("2020/CS/0011", "CS 2004", 01, 1.01),
    ("2020/CS/0011", "CS 2004", 01, 1.02),
    ("2020/CS/0011", "CS 2004", 02, 2.01),
    ("2020/CS/0011", "CS 2004", 02, 2.02),
    ("2020/CS/0011", "CS 2004", 02, 2.03),
    ("2020/CS/0011", "CS 2004", 03, 3.01),
    ("2020/CS/0011", "CS 2004", 03, 3.02),
    ("2020/CS/0011", "CS 2004", 03, 3.03),
    ("2020/CS/0014", "CS 2001", 01, 1.01),
    ("2020/CS/0014", "CS 2001", 01, 1.02),
    ("2020/CS/0014", "CS 2001", 01, 1.03),
    ("2020/CS/0014", "CS 2001", 01, 1.04),
    ("2020/CS/0014", "CS 2001", 02, 2.01),
    ("2020/CS/0014", "CS 2001", 02, 2.02),
    ("2020/CS/0014", "CS 2001", 02, 2.03),
    ("2020/CS/0014", "CS 2001", 03, 3.01),
    ("2020/CS/0014", "CS 2001", 03, 3.02),
    ("2020/CS/0014", "CS 2001", 03, 3.03),
    ("2020/CS/0014", "CS 2002", 01, 1.01),
    ("2020/CS/0014", "CS 2002", 01, 1.02),
    ("2020/CS/0014", "CS 2002", 01, 1.03),
    ("2020/CS/0014", "CS 2002", 02, 2.01),
    ("2020/CS/0014", "CS 2002", 02, 2.02),
    ("2020/CS/0014", "CS 2002", 02, 2.03),
    ("2020/CS/0014", "CS 2002", 03, 3.01),
    ("2020/CS/0014", "CS 2002", 03, 3.02),
    ("2020/CS/0014", "CS 2002", 03, 3.03),
    ("2020/CS/0014", "CS 2002", 03, 3.04),
    ("2020/CS/0014", "CS 2003", 01, 1.01),
    ("2020/CS/0014", "CS 2003", 01, 1.02),
    ("2020/CS/0014", "CS 2003", 01, 1.03),
    ("2020/CS/0014", "CS 2003", 02, 2.01),
    ("2020/CS/0014", "CS 2003", 02, 2.02),
    ("2020/CS/0014", "CS 2003", 02, 2.03),
    ("2020/CS/0014", "CS 2003", 03, 3.01),
    ("2020/CS/0014", "CS 2003", 03, 3.02),
    ("2020/CS/0014", "CS 2003", 03, 3.03),
    ("2020/CS/0014", "CS 2004", 01, 1.01),
    ("2020/CS/0014", "CS 2004", 01, 1.02),
    ("2020/CS/0014", "CS 2004", 02, 2.01),
    ("2020/CS/0014", "CS 2004", 02, 2.02),
    ("2020/CS/0014", "CS 2004", 02, 2.03),
    ("2020/CS/0014", "CS 2004", 03, 3.01),
    ("2020/CS/0014", "CS 2004", 03, 3.02),
    ("2020/CS/0014", "CS 2004", 03, 3.03),
    ("2020/CS/0026", "CS 2001", 01, 1.01),
    ("2020/CS/0026", "CS 2001", 01, 1.02),
    ("2020/CS/0026", "CS 2001", 01, 1.03),
    ("2020/CS/0026", "CS 2001", 01, 1.04),
    ("2020/CS/0026", "CS 2001", 02, 2.01),
    ("2020/CS/0026", "CS 2001", 02, 2.02),
    ("2020/CS/0026", "CS 2001", 02, 2.03),
    ("2020/CS/0026", "CS 2001", 03, 3.01),
    ("2020/CS/0026", "CS 2001", 03, 3.02),
    ("2020/CS/0026", "CS 2001", 03, 3.03),
    ("2020/CS/0026", "CS 2003", 01, 1.01),
    ("2020/CS/0026", "CS 2003", 01, 1.02),
    ("2020/CS/0026", "CS 2003", 01, 1.03),
    ("2020/CS/0026", "CS 2003", 02, 2.01),
    ("2020/CS/0026", "CS 2003", 02, 2.02),
    ("2020/CS/0026", "CS 2003", 02, 2.03),
    ("2020/CS/0026", "CS 2003", 03, 3.01),
    ("2020/CS/0026", "CS 2003", 03, 3.02),
    ("2020/CS/0026", "CS 2003", 03, 3.03),
    ("2020/CS/0026", "CS 2004", 01, 1.01),
    ("2020/CS/0026", "CS 2004", 01, 1.02),
    ("2020/CS/0026", "CS 2004", 02, 2.01),
    ("2020/CS/0026", "CS 2004", 02, 2.02),
    ("2020/CS/0026", "CS 2004", 02, 2.03),
    ("2020/CS/0026", "CS 2004", 03, 3.01),
    ("2020/CS/0026", "CS 2004", 03, 3.02),
    ("2020/CS/0026", "CS 2004", 03, 3.03),
    ("2020/CS/0044", "CS 2001", 01, 1.01),
    ("2020/CS/0044", "CS 2001", 01, 1.02),
    ("2020/CS/0044", "CS 2001", 01, 1.03),
    ("2020/CS/0044", "CS 2001", 01, 1.04),
    ("2020/CS/0044", "CS 2001", 02, 2.01),
    ("2020/CS/0044", "CS 2001", 02, 2.02),
    ("2020/CS/0044", "CS 2001", 02, 2.03),
    ("2020/CS/0044", "CS 2001", 03, 3.01),
    ("2020/CS/0044", "CS 2001", 03, 3.02),
    ("2020/CS/0044", "CS 2001", 03, 3.03),
    ("2020/CS/0044", "CS 2003", 01, 1.01),
    ("2020/CS/0044", "CS 2003", 01, 1.02),
    ("2020/CS/0044", "CS 2003", 01, 1.03),
    ("2020/CS/0044", "CS 2003", 02, 2.01),
    ("2020/CS/0044", "CS 2003", 02, 2.02),
    ("2020/CS/0044", "CS 2003", 02, 2.03),
    ("2020/CS/0044", "CS 2003", 03, 3.01),
    ("2020/CS/0044", "CS 2003", 03, 3.02),
    ("2020/CS/0044", "CS 2003", 03, 3.03),
    ("2020/CS/0044", "CS 2004", 01, 1.01),
    ("2020/CS/0044", "CS 2004", 01, 1.02),
    ("2020/CS/0044", "CS 2004", 02, 2.01),
    ("2020/CS/0044", "CS 2004", 02, 2.02),
    ("2020/CS/0044", "CS 2004", 02, 2.03),
    ("2020/CS/0044", "CS 2004", 03, 3.01),
    ("2020/CS/0044", "CS 2004", 03, 3.02),
    ("2020/CS/0044", "CS 2004", 03, 3.03),
    ("2020/IS/0016", "IS 2001", 01, 1.01),
    ("2020/IS/0016", "IS 2001", 01, 1.02),
    ("2020/IS/0016", "IS 2001", 01, 1.03),
    ("2020/IS/0016", "IS 2001", 02, 2.01),
    ("2020/IS/0016", "IS 2001", 02, 2.02),
    ("2020/IS/0016", "IS 2001", 02, 2.03),
    ("2020/IS/0016", "IS 2001", 03, 3.01),
    ("2020/IS/0016", "IS 2001", 03, 3.02),
    ("2020/IS/0016", "IS 2001", 03, 3.03),
    ("2020/IS/0016", "IS 2002", 01, 1.01),
    ("2020/IS/0016", "IS 2002", 01, 1.02),
    ("2020/IS/0016", "IS 2002", 01, 1.03),
    ("2020/IS/0016", "IS 2002", 02, 2.01),
    ("2020/IS/0016", "IS 2002", 02, 2.02),
    ("2020/IS/0016", "IS 2002", 02, 2.03),
    ("2020/IS/0016", "IS 2002", 02, 2.04),
    ("2020/IS/0016", "IS 2002", 03, 3.01),
    ("2020/IS/0016", "IS 2002", 03, 3.02),
    ("2020/IS/0016", "IS 2002", 03, 3.03),
    ("2020/IS/0016", "IS 2003", 01, 1.01),
    ("2020/IS/0016", "IS 2003", 01, 1.02),
    ("2020/IS/0016", "IS 2003", 01, 1.03),
    ("2020/IS/0016", "IS 2003", 02, 2.01),
    ("2020/IS/0016", "IS 2003", 02, 2.02),
    ("2020/IS/0016", "IS 2003", 02, 2.03),
    ("2020/IS/0016", "IS 2003", 03, 3.01),
    ("2020/IS/0016", "IS 2003", 03, 3.02),
    ("2020/IS/0032", "IS 2001", 01, 1.01),
    ("2020/IS/0032", "IS 2001", 01, 1.02),
    ("2020/IS/0032", "IS 2001", 01, 1.03),
    ("2020/IS/0032", "IS 2001", 02, 2.01),
    ("2020/IS/0032", "IS 2001", 02, 2.02),
    ("2020/IS/0032", "IS 2001", 02, 2.03),
    ("2020/IS/0032", "IS 2001", 03, 3.01),
    ("2020/IS/0032", "IS 2001", 03, 3.02),
    ("2020/IS/0032", "IS 2001", 03, 3.03),
    ("2020/IS/0032", "IS 2002", 01, 1.01),
    ("2020/IS/0032", "IS 2002", 01, 1.02),
    ("2020/IS/0032", "IS 2002", 01, 1.03),
    ("2020/IS/0032", "IS 2002", 02, 2.01),
    ("2020/IS/0032", "IS 2002", 02, 2.02),
    ("2020/IS/0032", "IS 2002", 02, 2.03),
    ("2020/IS/0032", "IS 2002", 02, 2.04),
    ("2020/IS/0032", "IS 2002", 03, 3.01),
    ("2020/IS/0032", "IS 2002", 03, 3.02),
    ("2020/IS/0032", "IS 2002", 03, 3.03),
    ("2020/IS/0032", "IS 2003", 01, 1.01),
    ("2020/IS/0032", "IS 2003", 01, 1.02),
    ("2020/IS/0032", "IS 2003", 01, 1.03),
    ("2020/IS/0032", "IS 2003", 02, 2.01),
    ("2020/IS/0032", "IS 2003", 02, 2.02),
    ("2020/IS/0032", "IS 2003", 02, 2.03),
    ("2020/IS/0032", "IS 2003", 03, 3.01),
    ("2020/IS/0032", "IS 2003", 03, 3.02),
    ("2020/IS/0051", "IS 2001", 01, 1.01),
    ("2020/IS/0051", "IS 2001", 01, 1.02),
    ("2020/IS/0051", "IS 2001", 01, 1.03),
    ("2020/IS/0051", "IS 2001", 02, 2.01),
    ("2020/IS/0051", "IS 2001", 02, 2.02),
    ("2020/IS/0051", "IS 2001", 02, 2.03),
    ("2020/IS/0051", "IS 2001", 03, 3.01),
    ("2020/IS/0051", "IS 2001", 03, 3.02),
    ("2020/IS/0051", "IS 2001", 03, 3.03),
    ("2020/IS/0051", "IS 2003", 01, 1.01),
    ("2020/IS/0051", "IS 2003", 01, 1.02),
    ("2020/IS/0051", "IS 2003", 01, 1.03),
    ("2020/IS/0051", "IS 2003", 02, 2.01),
    ("2020/IS/0051", "IS 2003", 02, 2.02),
    ("2020/IS/0051", "IS 2003", 02, 2.03),
    ("2020/IS/0051", "IS 2003", 03, 3.01),
    ("2020/IS/0051", "IS 2003", 03, 3.02),
    ("2020/IS/0075", "IS 2001", 01, 1.01),
    ("2020/IS/0075", "IS 2001", 01, 1.02),
    ("2020/IS/0075", "IS 2001", 01, 1.03),
    ("2020/IS/0075", "IS 2001", 02, 2.01),
    ("2020/IS/0075", "IS 2001", 02, 2.02),
    ("2020/IS/0075", "IS 2001", 02, 2.03),
    ("2020/IS/0075", "IS 2001", 03, 3.01),
    ("2020/IS/0075", "IS 2001", 03, 3.02),
    ("2020/IS/0075", "IS 2001", 03, 3.03),
    ("2020/IS/0075", "IS 2003", 01, 1.01),
    ("2020/IS/0075", "IS 2003", 01, 1.02),
    ("2020/IS/0075", "IS 2003", 01, 1.03),
    ("2020/IS/0075", "IS 2003", 02, 2.01),
    ("2020/IS/0075", "IS 2003", 02, 2.02),
    ("2020/IS/0075", "IS 2003", 02, 2.03),
    ("2020/IS/0075", "IS 2003", 03, 3.01),
    ("2020/IS/0075", "IS 2003", 03, 3.02);

INSERT INTO StuCourse (stu_reg_no, course_code, semester) VALUES
    ("2020/CS/0011", "CS 2001", 3),
    ("2020/CS/0011", "CS 2002", 3),
    ("2020/CS/0011", "CS 2003", 3),
    ("2020/CS/0011", "CS 2004", 3),
    ("2020/CS/0014", "CS 2001", 3),
    ("2020/CS/0014", "CS 2002", 3),
    ("2020/CS/0014", "CS 2003", 3),
    ("2020/CS/0014", "CS 2004", 3),
    ("2020/CS/0026", "CS 2001", 3),
    ("2020/CS/0026", "CS 2003", 3),
    ("2020/CS/0026", "CS 2004", 3),
    ("2020/CS/0044", "CS 2001", 3),
    ("2020/CS/0044", "CS 2003", 3),
    ("2020/CS/0044", "CS 2004", 3),
    ("2020/IS/0016", "IS 2001", 3),
    ("2020/IS/0016", "IS 2002", 3),
    ("2020/IS/0016", "IS 2003", 3),
    ("2020/IS/0032", "IS 2001", 3),
    ("2020/IS/0032", "IS 2002", 3),
    ("2020/IS/0032", "IS 2003", 3),
    ("2020/IS/0051", "IS 2001", 3),
    ("2020/IS/0051", "IS 2003", 3),
    ("2020/IS/0075", "IS 2001", 3),
    ("2020/IS/0075", "IS 2003", 3);

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

INSERT INTO StuCourseSubmission (stu_reg_no, course_code, submission_id) VALUES
    ("2020/CS/0011", "CS 2001", "1C01"),
    ("2020/CS/0011", "CS 2003", "2C03"),
    ("2020/CS/0011", "CS 2004", "2C04"),
    ("2020/CS/0014", "CS 2001", "1C01"),
    ("2020/CS/0014", "CS 2003", "2C03"),
    ("2020/CS/0014", "CS 2004", "2C04"),
    ("2020/CS/0026", "CS 2001", "1C01"),
    ("2020/CS/0026", "CS 2003", "2C03"),
    ("2020/CS/0026", "CS 2004", "2C04"),
    ("2020/CS/0044", "CS 2001", "1C01"),
    ("2020/CS/0044", "CS 2003", "2C03"),
    ("2020/CS/0044", "CS 2004", "2C04"),
    ("2020/IS/0016", "IS 2001", "1I01"),
    ("2020/IS/0016", "IS 2003", "2I03"),
    ("2020/IS/0032", "IS 2001", "1I01"),
    ("2020/IS/0032", "IS 2003", "2I03"),
    ("2020/IS/0051", "IS 2001", "1I01"),
    ("2020/IS/0051", "IS 2003", "2I03"),
    ("2020/IS/0075", "IS 2001", "1I01"),
    ("2020/IS/0075", "IS 2003", "2I03");


 
