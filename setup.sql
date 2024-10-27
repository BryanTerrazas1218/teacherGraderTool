-- Create the database
CREATE DATABASE GradingTool;

USE GradingTool;

-- Create table for students
CREATE TABLE Students (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50)
);

-- Create table for grades
CREATE TABLE Grades (
    GradeID INT PRIMARY KEY AUTO_INCREMENT,
    StudentID INT,
    Homework1 INT,
    Homework2 INT,
    Homework3 INT,
    Homework4 INT,
    Homework5 INT,
    Quiz1 INT,
    Quiz2 INT,
    Quiz3 INT,
    Quiz4 INT,
    Quiz5 INT,
    Midterm INT,
    FinalProject INT,
    FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);

-- Insert example students
INSERT INTO Students (FirstName, LastName) VALUES ('John', 'Doe');
INSERT INTO Students (FirstName, LastName) VALUES ('Jane', 'Smith');
INSERT INTO Students (FirstName, LastName) VALUES ('Alice', 'Johnson');
