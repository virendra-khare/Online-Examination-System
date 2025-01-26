<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "project3") or die("Connection failed: " . mysqli_connect_error());

// Fetch quizzes for the dropdown
$quiz_query = "SELECT id, title FROM quiz";
$quiz_result = mysqli_query($con, $quiz_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_questions'])) {
    $quiz_id = $_POST['quiz_id'];
    $num_questions = $_POST['num_questions'];

    // Store the number of questions in a session for next form submission
    $_SESSION['quiz_id'] = $quiz_id;
    $_SESSION['num_questions'] = $num_questions;

    header("Location: add_questions_details.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Questions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; margin: auto; }
        select, input[type="number"], button { width: 100%; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Create Questions</h1>
    <form method="POST">
        <label for="quiz_id">Select Exam:</label>
        <select name="quiz_id" id="quiz_id" required>
            <option value="">-- Select Exam --</option>
            <?php while ($quiz = mysqli_fetch_assoc($quiz_result)) { ?>
                <option value="<?php echo $quiz['id']; ?>"><?php echo $quiz['title']; ?></option>
            <?php } ?>
        </select>

        <label for="num_questions">Number of Questions:</label>
        <input type="number" name="num_questions" id="num_questions" min="1" required>

        <button type="submit" name="create_questions">Next</button>
    </form>
</body>
</html>
