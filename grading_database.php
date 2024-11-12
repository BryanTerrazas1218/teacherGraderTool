<?php
// grading_database.php

function get_student_id($conn, $student_name) {
    $check_student = $conn->query("SELECT id FROM students WHERE name = '$student_name'");
    if ($check_student->num_rows > 0) {
        return $check_student->fetch_assoc()['id'];
    }
    $conn->query("INSERT INTO students (name) VALUES ('$student_name')");
    return $conn->insert_id;
}

function insert_grades($conn, $student_id, $homeworks, $quizzes, $midterm, $final_project, $final_grade) {
    $insert_query = "
        INSERT INTO grades (
            student_id, homework1, homework2, homework3, homework4, homework5,
            quiz1, quiz2, quiz3, quiz4, quiz5, midterm, final_project, final_grade
        ) VALUES (
            $student_id, $homeworks[0], $homeworks[1], $homeworks[2], $homeworks[3], $homeworks[4],
            $quizzes[0], $quizzes[1], $quizzes[2], $quizzes[3], $quizzes[4], $midterm, $final_project, $final_grade
        )";
    return $conn->query($insert_query);
}
