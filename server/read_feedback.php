<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Feedback</title>
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
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table thead {
            background-color: #4CAF50;
            color: white;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .search-container {
            width: 90%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
        }
        .search-container input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Student Feedback</h1>
    
    <div class="search-container">
        <label for="search">Search Feedback:</label>
        <input type="text" id="search" placeholder="Type to search...">
    </div>
    
    <table id="feedback-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "project3";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch feedback from the database
            $sql = "SELECT * FROM contacts ORDER BY submitted_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['subject']) . "</td>
                            <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                            <td>" . $row['submitted_at'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No feedback found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        // JavaScript to enable search functionality
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('#feedback-table tbody tr');

        searchInput.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const cells = Array.from(row.getElementsByTagName('td'));
                const rowText = cells.map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = rowText.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
