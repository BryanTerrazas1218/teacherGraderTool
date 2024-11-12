<?php
require_once 'grading_database.php';
require_once 'grading_functions.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grades_db_test";  
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function assert_equal($expected, $actual, $message) {
    if ($expected === $actual) {
        echo "$message: Passed\n";
    } else {
        echo "$message: Failed - Expected $expected, got $actual\n";
    }
}

// Test function for inserting grades
function test_insert_grades($conn) {
    $student_name = "Test Student";
    $student_id = get_student_id($conn, $student_name);

    $homeworks = [85, 90, 88, 92, 80];
    $quizzes = [70, 85, 90, 75, 65];
    $midterm = 88;
    $final_project = 90;
    $final_grade = calculate_final_grade($homeworks, $quizzes, $midterm, $final_project);

    $result = insert_grades($conn, $student_id, $homeworks, $quizzes, $midterm, $final_project, $final_grade);
    assert_equal(true, $result, "Test insert_grades");
}

// Run the test
test_insert_grades($conn);

// Clean up
$conn->query("DELETE FROM students WHERE name = 'Test Student'");
$conn->close();
?>
