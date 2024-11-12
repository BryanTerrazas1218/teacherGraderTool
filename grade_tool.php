<?php
require_once 'grading_functions.php';
require_once 'grading_database.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grades_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $student_name = $conn->real_escape_string(trim($_POST['student_name']));
    $homeworks = array_map('intval', [
        $_POST['homework1'], $_POST['homework2'], $_POST['homework3'], $_POST['homework4'], $_POST['homework5']
    ]);
    $quizzes = array_map('intval', [
        $_POST['quiz1'], $_POST['quiz2'], $_POST['quiz3'], $_POST['quiz4'], $_POST['quiz5']
    ]);
    $midterm = intval($_POST['midterm']);
    $final_project = intval($_POST['final_project']);

    // Calculate final grade and retrieve student ID
    $final_grade = calculate_final_grade($homeworks, $quizzes, $midterm, $final_project);
    $student_id = get_student_id($conn, $student_name);

    // Insert grades into the database
    if (insert_grades($conn, $student_id, $homeworks, $quizzes, $midterm, $final_project, $final_grade)) {
        echo "Grades saved successfully for $student_name. Final grade: $final_grade";
    } else {
        echo "Error: " . $conn->error;
}

$conn->close();
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Teacher's Grade Tool</title>
</head>
<body>
    <h2>Enter Grades for Students</h2>
    <form method="post" action="">
        <label for="student_name">Enter Student Name:</label>
        <input type="text" name="student_name" required><br>
        
        <h3>Homework Scores</h3>
        <input type="number" name="homework1" required> Homework 1<br>
        <input type="number" name="homework2" required> Homework 2<br>
        <input type="number" name="homework3" required> Homework 3<br>
        <input type="number" name="homework4" required> Homework 4<br>
        <input type="number" name="homework5" required> Homework 5<br>
        
        <h3>Quiz Scores</h3>
        <input type="number" name="quiz1" required> Quiz 1<br>
        <input type="number" name="quiz2" required> Quiz 2<br>
        <input type="number" name="quiz3" required> Quiz 3<br>
        <input type="number" name="quiz4" required> Quiz 4<br>
        <input type="number" name="quiz5" required> Quiz 5<br>
        
        <h3>Midterm</h3>
        <input type="number" name="midterm" required><br>
        
        <h3>Final Project</h3>
        <input type="number" name="final_project" required><br>
        
        <button type="submit">Calculate and Save Final Grade</button>
    </form>
</body>
</html>
