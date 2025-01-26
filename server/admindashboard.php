<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 15px 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }

        /* Dashboard Layout */
        .container {
            display: flex;
            flex-wrap: wrap;
        }
        .sidebar {
            background-color: #222;
            color: white;
            padding: 20px;
            width: 250px;
            flex-shrink: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }
        .sidebar a:hover {
            background-color: #575757;
            padding-left: 10px;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }

        /* Cards Section */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .card h3 {
            margin: 0;
            color: #333;
        }
        .card p {
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                text-align: center;
            }
            nav {
                text-align: center;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<nav>
    <a href="#">Home</a>
    <a href="add-quiz.php">Add Exam</a>
    <a href="add_questions.php">Add Questions</a>
    <a href="manage_student.php">Manage Student</a>
    <a href="admin_notice.php">Notice</a>
    <?php echo "User Id - " . $_SESSION["user_id"] . ""; ?>
    <a href="logout.php" style="color: red;">Logout</a>
</nav>

<div class="container">
    <!-- Sidebar -->
   

    <!-- Main Content -->
    <section class="main-content">
        <h2>Welcome</h2>
       <!-- <div class="grid">
            <div class="card">
                <h3>Total Users</h3>
                <p>1,234</p>
            </div>
            <div class="card">
                <h3>New Signups</h3>
                <p>56</p>
            </div>
            <div class="card">
                <h3>Revenue</h3>
                <p>$12,345</p>
            </div>
            <div class="card">
                <h3>Active Sessions</h3>
                <p>89</p>
            </div>
        </div>-->
        
    </section>
</div>

</body>
</html>