<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project3";
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully<br>";

// Functions

    // Generate User ID
    function generateUserId($collegeName) {
    
        // Remove spaces and special characters, and convert to lowercase
        $formattedName = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', substr($collegeName, 0, 2)));
        // Generate a random 4-digit number
        $randomNumber = random_int(1000, 9999);
    
        // Concatenate the formatted name and random number to create the username
        $username = $formattedName . $randomNumber;
    
        return $username;
    }

    // Generate Password
    function generateNumericPassword($length = 8) {
        // Ensure the length is a positive integer
        if ($length <= 0) {
            return "";
        }
    
        $numericCharacters = '0123456789'; // Numeric characters
        $password = '';
        $maxIndex = strlen($numericCharacters) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, $maxIndex); // Generate a random index
            $password .= $numericCharacters[$randomIndex]; // Append a random digit
        }
    
        return $password;
    }

// User Registration
if (isset($_POST['register'])) {
    // Generate random User ID and Password
    $name = htmlspecialchars(trim($_POST["name"]));
    $user_id = generateUserId($name); // 16-character random user ID
    $password_plain = generateNumericPassword(8); // Random plaintext password
    $hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);

    // Securely get user inputs
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone_no = htmlspecialchars(trim($_POST["phone-no"]));
    $course = htmlspecialchars(trim($_POST["course"]));
    $year = htmlspecialchars(trim($_POST["year"]));
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $dob = htmlspecialchars(trim($_POST["dob"]));
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");


    try {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO `student` 
            (`user_id`, `password`, `name`, `email`, `phone_no`, `course`, `course_year`, `gender`, `dob`, `created_at`, `update_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssssssss",
            $user_id,
            $hashed_password,
            $name,
            $email,
            $phone_no,
            $course,
            $year,
            $gender,
            $dob,
            $created_at,
            $updated_at
        );

        if ($stmt->execute()) {
            echo "Registration successful!<br>Your User ID: $user_id<br>Your Password: $password_plain";
        } else {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Something went wrong. Please try again.";
    }
}

// User Login


if (isset($_POST['login'])) {
    $userid = htmlspecialchars(trim($_POST["userid"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    try {
        // Prepare and execute query
        $stmt = $conn->prepare("SELECT user_id, name, password FROM `student` WHERE user_id = ?");
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify password
                if (password_verify($password, $hashed_password)) {
                    // Login successful, set session variables
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['name'];
                    echo "Login successful! <br>";
                    echo "" . $_SESSION["user_id"] . ".<br>";
                    header("Location: studentdashboard.php");
                    exit(); // Ensure the script stops after redirection
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "Invalid User ID.";
            }
        } else {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Something went wrong. Please try again.";
    }
}


/*
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['userid']);
    $password = $_POST['password'];

    $query = "SELECT * FROM student WHERE user_id = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;

            echo "login";
         //   header("Location: index.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}*/

// Admin Login

if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['userid']);
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE user_id = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        //if (password_verify($password, $row['password'])) 
        if($password == $row['password']){
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            header("Location: admindashboard.php");
        } else {
            echo "Wrong password.";
        }
    } else {
        echo "User not found.";
    }
}


// Head Login

if (isset($_POST['login_head'])) {
    $username = mysqli_real_escape_string($conn, $_POST['userid']);
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE user_id = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        //if (password_verify($password, $row['password'])) 
        if($password == $row['password']){
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            header("Location: head_dashboard.php");
        } else {
            echo "Wrong password.";
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
