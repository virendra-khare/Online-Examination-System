<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        form {
            margin: 20px auto;
            width: 80%;
            text-align: center;
        }
        form input, form button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Student Management System</h1>

    <!-- Add New Student 
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="grade" placeholder="Grade" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <button type="submit" name="add">Add Student</button>
    </form>
    -->
    
    <!-- Search Student -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by Name or Grade">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Year</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Account Created</th>
                <th>Last Updated</th>
                <th>Delete Studnet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database Connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "project3";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

         /*   // Add Student
            if (isset($_POST['add'])) {
                $name = $_POST['name'];
                $grade = $_POST['grade'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                $stmt = $conn->prepare("INSERT INTO student (name, grade, email, phone) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $grade, $email, $phone);
                $stmt->execute();
                $stmt->close();

                header("Location: index.php");
            }*/

            // Delete Student
            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $stmt = $conn->prepare("DELETE FROM student WHERE user_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                echo "student deleted";
              //  header("Location: index.php");
            }

            // Search Students
            $search_query = "";
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $search_query = "WHERE name LIKE '%$search%' OR user_id LIKE '%$search%'";
            }

            // Fetch Students
            $sql = "SELECT * FROM student $search_query";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone_no']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['course_year']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['dob']}</td>
                            <td>{$row['created_at']}</td>
                            <td>{$row['update_at']}</td>
                            <td>
                                <a href='?delete={$row['user_id']}' style='color: red;'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
