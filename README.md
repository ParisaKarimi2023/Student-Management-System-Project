# Student Grade Management System
## List of Contents
1.	System requirements analysis
2.	Database design
3.	Application Structure
4.	Implementation of Admin panel features
5.	Implementation of Professor panel features
6.	Implementation of Student panel features
7.	SQL Injection Attack
8.	Prevent from SQL Injection Attack
9.	XSS Attack
a.	Stored XSS Attack
b.	Prevent from stored XSS attack
c.	Reflected XSS Attack
d.	Prevent from reflected XSS attack
e.	DOM-based XSS Attack
f.	Prevent from DOM-based XSS attack
--------------------------------
## System requirements analysis :
Purpose: The purpose is  designing a web-based application where professors can enter their students' grades into the application and manage them.
And in the next step, our goal is to attack the application with sql injection attack and xss attack. To carry out these attacks,
we need to expand the initial design of the application and add facilities to it so that we can carry out attacks on those facilities. For this purpose, we considered three roles in the application:
1.	Admin role
2.	Professor role
3.	Student role
---------------------------------------------
## Tasks of Admin role :
#### 1- Creating, deleting and editing professors as well as viewing the list of professors.
#### 2- Create, delete and edit courses as well as view the list of courses.
#### 3- Creating, deleting and editing students as well as viewing the list of students.
--------------------------------
## Tasks of Professor role :
#### 1-	grading the students in the courses offered by the professor.
#### 2-	Viewing the list of students who chose the courses that the professor presented.
#### 3-	handle the student grade appeal request.
--------------------------------------------
## Tasks of Student role :
#### 1- Viewing the list of grades of the courses he has chosen.
#### 2- Send grade appeal request
#### Considering that each role has specific tasks, the users of these roles are also limited to the tasks of the same role. To achieve this,
#### a management panel should be considered for each role, in which the user of the role will be limited to performing the tasks of the role. And he can log in and log out of his management panel.
------------------------------------
## Database design :
 Considering that the data entered in the application is supposed to be stored permanently, a database must be designed to store the data permanently.
Designing database tables and communicating between them:
According to the analysis of the application requirements, these tables are conceivable for data storage:
#### 1- users table: maintaining user data
#### 2- roles table: maintaining role data
#### 3- courses table: maintaining course data
#### 4- students table: maintaining student data
#### 5- course_student table: because there is a many-to-many relationship between the courses and students table, we considered this table to store the data of this relationship.
#### 6- grade_appeal table: maintaining grade appeal data.
-------------------------------------------------
## Application Structure :
#### ``Admin Folder:`` The admin folder contains the source codes related to the implementationof the features of the Admin panel and the Professor panel.
#### ``Student Folder:`` contains the source codes related to the implementation of the features of the Student panel.
#### ``Assets Folder:`` contains css, js, images, ...
#### ``Includes Folder :`` contains the most used php filesthat are used throughout the project
#### ``Common Folder:`` shared php files between the admin folder(source related to Admin and Professor panel features) and student folder (source related to Student panel features)
#### ``Filters Folder:`` It contains source code files whose job is to control access to different parts of the application.
----------------------------------------------------
### References
#### https://portswigger.net/web-security/cross-site-scripting
#### https://portswigger.net/web-security/sql-injection




