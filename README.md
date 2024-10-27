# teacherGraderTool
Grading Tool
Overview
This tool is designed to help teachers calculate final grades for students based on a rubric that includes homework, quizzes, midterm, and a final project. The tool handles all calculations and stores the information in a database.

Features
Calculates weighted final grades based on the following criteria:
Homework: 20% (average of 5 assignments)
Quizzes: 10% (average of 4 quizzes, with the lowest score dropped)
Midterm: 30%
Final Project: 40%
Stores all student grades and allows teachers to view final grades.
Simple and easy-to-use interface.
Setup Instructions
1. Database Setup
Import the provided setup.sql file into your MySQL database to create the required tables and insert sample students.
You can do this via phpMyAdmin
2. PHP Tool Setup
Place the PHP file (grade_tool.php) on xammp or a similar server.
Update the database connection details in the PHP file.
3. Adding Grades
Open the PHP file and enter student IDs and their grades in the insertGrades function.
Run the PHP script to insert the grades into the database. The tool will automatically calculate and display the final grade.
Usage Example
To add grades for a student:

Enter the grades in the following format:
$grades = [
    'Homework1' => 80,
    'Homework2' => 90,
    'Homework3' => 85,
    'Homework4' => 70,
    'Homework5' => 95,
    'Quiz1' => 60,
    'Quiz2' => 75,
    'Quiz3' => 80,
    'Quiz4' => 90,
    'Quiz5' => 65,
    'Midterm' => 88,
    'FinalProject' => 92
];
