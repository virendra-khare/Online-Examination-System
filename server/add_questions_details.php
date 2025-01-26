<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['quiz_id']) || !isset($_SESSION['num_questions'])) {
    header("Location: add_questions.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "project3") or die("Connection failed: " . mysqli_connect_error());

$quiz_id = $_SESSION['quiz_id'];
$num_questions = $_SESSION['num_questions'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_questions'])) {
    for ($i = 1; $i <= $num_questions; $i++) {
        $question = mysqli_real_escape_string($con, $_POST["question_$i"]);
        $option1 = mysqli_real_escape_string($con, $_POST["option1_$i"]);
        $option2 = mysqli_real_escape_string($con, $_POST["option2_$i"]);
        $option3 = mysqli_real_escape_string($con, $_POST["option3_$i"]);
        $option4 = mysqli_real_escape_string($con, $_POST["option4_$i"]);
        $correct_option = intval($_POST["correct_option_$i"]);

        $query = "INSERT INTO questions (quiz_id, question, option1, option2, option3, option4, correct_option) 
                  VALUES ('$quiz_id', '$question', '$option1', '$option2', '$option3', '$option4', '$correct_option')";
        mysqli_query($con, $query) or die("Error: " . mysqli_error($con));
    }

    unset($_SESSION['quiz_id'], $_SESSION['num_questions']); // Clear session variables
    echo "<h1>Questions Added Successfully!</h1>";
    echo "<a href='add_questions.php'>Add More Questions</a> | <a href='index.php'>Go to Home</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Questions Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; margin: auto; }
        textarea, input[type="text"], input[type="number"], button { width: 100%; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Add Questions</h1>
    <form method="POST">
        <?php for ($i = 1; $i <= $num_questions; $i++) { ?>
            <fieldset style="margin-bottom: 20px; padding: 10px;">
                <legend>Question <?php echo $i; ?></legend>
                <textarea name="question_<?php echo $i; ?>" placeholder="Enter question" required></textarea>
                <input type="text" name="option1_<?php echo $i; ?>" placeholder="Option 1" required>
                <input type="text" name="option2_<?php echo $i; ?>" placeholder="Option 2" required>
                <input type="text" name="option3_<?php echo $i; ?>" placeholder="Option 3" required>
                <input type="text" name="option4_<?php echo $i; ?>" placeholder="Option 4" required>
                <label for="correct_option_<?php echo $i; ?>">Correct Option (1-4):</label>
                <input type="number" name="correct_option_<?php echo $i; ?>" min="1" max="4" required>
            </fieldset>
        <?php } ?>
        <button type="submit" name="submit_questions">Submit Questions</button>
    </form>
</body>
</html>
