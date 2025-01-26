<?php
$con = mysqli_connect("localhost", "root", "", "project3") or die("Connection failed: " . mysqli_connect_error());
session_start();
$quiz_id = $_GET['id'];
$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
$query = "SELECT * FROM quiz WHERE id = $quiz_id";
$quiz = mysqli_fetch_assoc(mysqli_query($con, $query));

$questions_query = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$questions = mysqli_query($con, $questions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $quiz['title']; ?> - Quiz</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .quiz-container { max-width: 600px; margin: auto; padding: 20px; }
        .question { margin-bottom: 20px; }
        .timer { font-size: 20px; font-weight: bold; text-align: right; }
    </style>
    <script>
        var seconds = 60 * <?php echo $quiz['time_limit']; ?>; // Time limit in seconds

        function updateTimer() {
            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = seconds % 60;

            if (remainingSeconds < 10) remainingSeconds = "0" + remainingSeconds;

            document.getElementById('timer').textContent = minutes + ":" + remainingSeconds;

            if (seconds === 0) {
                clearInterval(timerInterval);
                document.getElementById('quiz-form').submit();
            } else {
                seconds--;
            }
        }

        var timerInterval = setInterval(updateTimer, 1000);
    </script>
</head>
<body>
    <div class="quiz-container">
        <h4 style="color: green; text-align: right;"><?php echo "User Id: $user_id"; ?></h4>
        <div class="timer">Time Remaining: <span id="timer"></span></div>
        <h1><?php echo $quiz['title']; ?></h1>
        <form id="quiz-form" action="submit.php" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <?php while ($row = mysqli_fetch_assoc($questions)) { ?>
                <div class="question">
                    <p><?php echo $row['question']; ?></p>
                    <input type="radio" name="q<?php echo $row['id']; ?>" value="1"> <?php echo $row['option1']; ?><br>
                    <input type="radio" name="q<?php echo $row['id']; ?>" value="2"> <?php echo $row['option2']; ?><br>
                    <input type="radio" name="q<?php echo $row['id']; ?>" value="3"> <?php echo $row['option3']; ?><br>
                    <input type="radio" name="q<?php echo $row['id']; ?>" value="4"> <?php echo $row['option4']; ?><br>
                </div>
            <?php } ?>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
