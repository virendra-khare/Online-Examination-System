<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .notice {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .notice:hover {
            transform: scale(1.02);
        }
        .notice h2 {
            margin: 0;
            color: #333;
        }
        .notice p {
            margin: 10px 0;
            color: #666;
        }
        .notice .date {
            font-size: 0.9em;
            color: #999;
        }
    </style>
</head>
<body>
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
</body>
</html>
