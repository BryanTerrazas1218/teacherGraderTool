<?php
// grading_functions.php

function calculate_final_grade($homeworks, $quizzes, $midterm, $final_project) {
    // Drop the lowest quiz score
    sort($quizzes);
    array_shift($quizzes);
    
    $homework_avg = array_sum($homeworks) / count($homeworks);
    $quiz_avg = array_sum($quizzes) / count($quizzes);
    
    $weighted_grade = ($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4);
    return round($weighted_grade);
}
