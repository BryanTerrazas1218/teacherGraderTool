-- Create the database
CREATE DATABASE IF NOT EXISTS grades_db;
USE grades_db;

-- Create students table
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Create grades table
CREATE TABLE grades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    homework1 INT,
    homework2 INT,
    homework3 INT,
    homework4 INT,
    homework5 INT,
    quiz1 INT,
    quiz2 INT,
    quiz3 INT,
    quiz4 INT,
    quiz5 INT,
    midterm INT,
    final_project INT,
    final_grade INT,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Insert sample students
INSERT INTO students (name) VALUES ('John Doe'), ('Jane Smith'), ('Alice Johnson');
