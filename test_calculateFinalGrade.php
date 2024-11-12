<?php
require_once 'grading_functions.php';


function assert_equal($expected, $actual, $message) {
    if ($expected === $actual) {
        echo "$message: Passed\n";
    } else {
        echo "$message: Failed - Expected $expected, got $actual\n";
    }
}

// Test function for grade calculation
function test_calculate_final_grade() {
    $homeworks = [85, 90, 88, 92, 80];
    $quizzes = [70, 85, 90, 75, 65];
    $midterm = 88;
    $final_project = 90;

    $final_grade = calculate_final_grade($homeworks, $quizzes, $midterm, $final_project);
    assert_equal(85, $final_grade, "Test calculate_final_grade");
}

// Run the test
test_calculate_final_grade();
?>
