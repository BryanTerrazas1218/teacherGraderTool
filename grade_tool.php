<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; //   
$dbname = "GradingTool";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to calculate final grade
function calculateFinalGrade($grades) {
    // Calculate homework average
    $homeworkAvg = array_sum(array_slice($grades, 0, 5)) / 5;

    // Drop lowest quiz and calculate quiz average
    $quizzes = array_slice($grades, 5, 5);
    sort($quizzes);
    array_shift($quizzes); // Drop lowest quiz
    $quizAvg = array_sum($quizzes) / 4;

    // Midterm and final project
    $midterm = $grades['Midterm'];
    $finalProject = $grades['FinalProject'];

    // Calculate weighted average
    $finalScore = ($homeworkAvg * 0.2) + ($quizAvg * 0.1) + ($midterm * 0.3) + ($finalProject * 0.4);
    return round($finalScore);
}

// Example function to insert grades into the database
function insertGrades($studentID, $grades) {
    global $conn;

    $sql = "INSERT INTO Grades (StudentID, Homework1, Homework2, Homework3, Homework4, Homework5, Quiz1, Quiz2, Quiz3, Quiz4, Quiz5, Midterm, FinalProject)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiiiiiii",
        $studentID,
        $grades['Homework1'],
        $grades['Homework2'],
        $grades['Homework3'],
        $grades['Homework4'],
        $grades['Homework5'],
        $grades['Quiz1'],
        $grades['Quiz2'],
        $grades['Quiz3'],
        $grades['Quiz4'],
        $grades['Quiz5'],
        $grades['Midterm'],
        $grades['FinalProject']
    );

    if ($stmt->execute()) {
        echo "Grades inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Sample input
$studentID = 1; // Example student ID
$grades = [
    'Homework1' => 75,
    'Homework2' => 89,
    'Homework3' => 103,
    'Homework4' => 55,
    'Homework5' => 100,
    'Quiz1' => 65,
    'Quiz2' => 78,
    'Quiz3' => 99,
    'Quiz4' => 76,
    'Quiz5' => 69,
    'Midterm' => 86,
    'FinalProject' => 90
];

// Insert grades into the database
insertGrades($studentID, $grades);

// Calculate and display the final grade
$finalGrade = calculateFinalGrade($grades);
echo "Final Grade: $finalGrade";

$conn->close();
?>


