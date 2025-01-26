<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "project3") or die("Connection failed: " . mysqli_connect_error());

$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
$quiz_id = mysqli_real_escape_string($con, $_POST['quiz_id']);

$questions_query = "SELECT * FROM questions WHERE quiz_id = '$quiz_id'";
$questions = mysqli_query($con, $questions_query);

$score = 0;
$total_questions = mysqli_num_rows($questions);

while ($row = mysqli_fetch_assoc($questions)) {
    $question_id = $row['id'];
    $correct_option = $row['correct_option'];

    if (isset($_POST["q$question_id"]) && $_POST["q$question_id"] == $correct_option) {
        $score++;
    }
}

// Insert result into the database
$query = "INSERT INTO results (user_id, quiz_id, score, total_questions) 
          VALUES ('$user_id', '$quiz_id', $score, $total_questions)";
if (!mysqli_query($con, $query)) {
    die("Error inserting results: " . mysqli_error($con));
}

// Display results
echo "<h1>Your Score: $score / $total_questions</h1>";
echo "<a href='studentdashboard.php'>Back to Home</a>";

mysqli_close($con);
?>
