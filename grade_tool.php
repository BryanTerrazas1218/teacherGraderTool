<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grades_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate weighted grade
function calculate_final_grade($homeworks, $quizzes, $midterm, $final_project) {
    // Drop the lowest quiz score
    sort($quizzes);
    array_shift($quizzes);
    
    $homework_avg = array_sum($homeworks) / count($homeworks);
    $quiz_avg = array_sum($quizzes) / count($quizzes);
    
    $weighted_grade = ($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4);
    return round($weighted_grade);
}

// Save student grades
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $homeworks = array_map('intval', [
        $_POST['homework1'], $_POST['homework2'], $_POST['homework3'], $_POST['homework4'], $_POST['homework5']
    ]);
    $quizzes = array_map('intval', [
        $_POST['quiz1'], $_POST['quiz2'], $_POST['quiz3'], $_POST['quiz4'], $_POST['quiz5']
    ]);
    $midterm = intval($_POST['midterm']);
    $final_project = intval($_POST['final_project']);

    $final_grade = calculate_final_grade($homeworks, $quizzes, $midterm, $final_project);

    // Check if the student already exists
    $check_student = $conn->query("SELECT id FROM students WHERE name = '$student_name'");
    if ($check_student->num_rows > 0) {
        // Student exists, fetch the student ID
        $student_id = $check_student->fetch_assoc()['id'];
    } else {
        // Insert new student and fetch the new ID
        $conn->query("INSERT INTO students (name) VALUES ('$student_name')");
        $student_id = $conn->insert_id;
    }

    // Insert grades 
    $insert_query = "
        INSERT INTO grades (
            student_id, homework1, homework2, homework3, homework4, homework5,
            quiz1, quiz2, quiz3, quiz4, quiz5, midterm, final_project, final_grade
        ) VALUES (
            $student_id, $homeworks[0], $homeworks[1], $homeworks[2], $homeworks[3], $homeworks[4],
            $quizzes[0], $quizzes[1], $quizzes[2], $quizzes[3], $quizzes[4], $midterm, $final_project, $final_grade
        )";

    if ($conn->query($insert_query) === TRUE) {
        echo "Grades saved successfully for $student_name. Final grade: $final_grade";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
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
        <input type="number" name="homework1" required min="0" max="100"> Homework 1<br>
        <input type="number" name="homework2" required min="0" max="100"> Homework 2<br>
        <input type="number" name="homework3" required min="0" max="100"> Homework 3<br>
        <input type="number" name="homework4" required min="0" max="100"> Homework 4<br>
        <input type="number" name="homework5" required min="0" max="100"> Homework 5<br>
        
        <h3>Quiz Scores</h3>
        <input type="number" name="quiz1" required min="0" max="100"> Quiz 1<br>
        <input type="number" name="quiz2" required min="0" max="100"> Quiz 2<br>
        <input type="number" name="quiz3" required min="0" max="100"> Quiz 3<br>
        <input type="number" name="quiz4" required min="0" max="100"> Quiz 4<br>
        <input type="number" name="quiz5" required min="0" max="100"> Quiz 5<br>
        
        <h3>Midterm</h3>
        <input type="number" name="midterm" required min="0" max="100"><br>
        
        <h3>Final Project</h3>
        <input type="number" name="final_project" required min="0" max="100"><br>
        
        <button type="submit">Calculate and Save Final Grade</button>
    </form>
</body>
</html>
