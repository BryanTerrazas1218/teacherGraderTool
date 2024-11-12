<?php
require_once 'grading_database.php';

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

// Test function for fetching or creating a student ID
function test_get_student_id($conn) {
    $student_name = "Test Student";

    // Check if a new ID is created
    $student_id = get_student_id($conn, $student_name);
    assert_equal(true, is_int($student_id), "Test get_student_id - New Student");

    // Check if the same ID is returned on subsequent calls
    $same_id = get_student_id($conn, $student_name);
    assert_equal($student_id, $same_id, "Test get_student_id - Existing Student");
}

// Run the test
test_get_student_id($conn);

// Clean up
$conn->query("DELETE FROM students WHERE name = 'Test Student'");
$conn->close();
?>
