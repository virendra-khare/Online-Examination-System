<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create Notice</title>
    <link rel="stylesheet" href="public/css/body.css">
    <link rel="stylesheet" href="public/css/notice_board.css">

    <style>

        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 50%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        form input, form textarea, form button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Create Notice</h1>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Notice Title" required>
        <textarea name="content" rows="5" placeholder="Write your notice here..." required></textarea>
        <button type="submit" name="submit">Post Notice</button>
    </form>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Save notice to database
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $conn->prepare("INSERT INTO notices (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Notice posted successfully!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error posting notice. Please try again.</p>";
        }
        $stmt->close();
    }

    $conn->close();
    ?>

    <!-- Notice SECTION Start -->
    <h1>Notices</h1>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notices from database
$sql = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='notice'>
                <h2>" . htmlspecialchars($row['title']) . "</h2>
                <p>" . nl2br(htmlspecialchars($row['content'])) . "</p>
                <p class='date'>Posted on: " . $row['created_at'] . "</p>
              </div>";
    }
} else {
    echo "<p style='text-align: center;'>No notices found.</p>";
}

$conn->close();
?>
    
<!-- Notice SECTION End -->
</body>
</html>
