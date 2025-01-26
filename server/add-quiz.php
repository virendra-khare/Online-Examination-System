<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project3";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $intro = htmlspecialchars(trim($_POST['intro']));
    $time_limit = intval($_POST['time_limit']);

    try {
        // Prepare and execute query
        $stmt = $conn->prepare("INSERT INTO quiz (title, intro, time_limit) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $intro, $time_limit);

        if ($stmt->execute()) {
            echo "Quiz added successfully!";
        } else {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Something went wrong. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add New Exam</h1>
    <form method="POST" action="">
        <label for="title">Exam Title / Subject:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="intro">Introduction:</label>
        <textarea id="intro" name="intro" rows="5"></textarea>
        
        <label for="time_limit">Time Limit (in minutes):</label>
        <input type="number" id="time_limit" name="time_limit" required>
        
        <button type="submit">Add Quiz</button>
    </form>
</body>
</html>
