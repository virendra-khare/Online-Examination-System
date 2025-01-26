<?php

// CONNECTING TO THE DATABASE
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a Nano User ID (short unique ID)
function generateUserId($length = 12): string {
    $numbers = '0123456789';
    $all = $numbers;

    $userid =   $numbers[rand(0, strlen($numbers) - 1)];

    for ($i = 4; $i < $length; $i++) {
        $userid .= $all[rand(0, strlen($all) - 1)];
    }

    return str_shuffle($userid);
}

// Function to generate a Password
function generatePassword($length = 8): string {
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $special = '@#$%!';
    $all = $lowercase . $uppercase . $numbers . $special;

    $password = $lowercase[rand(0, strlen($lowercase) - 1)] .
                $uppercase[rand(0, strlen($uppercase) - 1)] .
                $numbers[rand(0, strlen($numbers) - 1)] .
                $special[rand(0, strlen($special) - 1)];

    for ($i = 4; $i < $length; $i++) {
        $password .= $all[rand(0, strlen($all) - 1)];
    }

    return str_shuffle($password);
}

// 1. REGISTER NEW USER
if (isset($_POST["register"])) {
    // VARIABLES (Sanitize and validate inputs)
    $user_id = generateUserId();
    $raw_password = generatePassword();
    $name = $conn->real_escape_string($_POST["name"]); 
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone-no"]);
    $course = $conn->real_escape_string($_POST["course"]);
    $year = $conn->real_escape_string($_POST["year"]);
    $gender = $conn->real_escape_string($_POST["gender"]);
    $dob = $conn->real_escape_string($_POST["dob"]);

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        die("Invalid phone number format");
    }

    if (!DateTime::createFromFormat('Y-m-d', $dob)) {
        die("Invalid date format");
    }

    // Hash the password before storing it
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // SQL Query - Use Prepared Statement to prevent SQL Injection
    $query = $conn->prepare("INSERT INTO `user`(`user id`, `password`, `name`, `email`, `phone_number`, `course`, `year`, `gender`, `dob`) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("sssssssss", $user_id, $raw_password, $name, $email, $phone, $course, $year, $gender, $dob);

    // Execute the query
    if ($query->execute()) {
        // Redirect to index.php with a success message
        header("Location: index.php");
        exit();
    } else {
        // Log error and show user-friendly message
        error_log("Database Error: " . $query->error);
        header("Location: register.php?error=Registration failed. Please try again.");
        exit();
    }

}





//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';
require('PHPMailer-master/src/Exception.php');
require('PHPMailer-master/src/SMTP.php');
require('PHPMailer-master/src/PHPMailer.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output (this show the functions running msg and errors msg)
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'cybernet6533@gmail.com';                     //SMTP username
    $mail->Password   = 'vqlgdsbhmivcpatl';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('cybernet6533@gmail.com', 'Near Website');
    $mail->addAddress('virendrakharez2005@gmail.com', 'Joe User');     //Add a recipient
 /*   $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');*/

/*  //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
*/
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'WHITEROOM Registration';
    $mail->Body    = 'Hello Mr./Miss. Name <?php $name ?>
    Your Registraton is Successfuly Submited <b>Your User ID = ____________ and Password = _____________</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}







/*/ 2. LOGIN (Example Implementation)
if (isset($_POST["login"])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT `password` FROM `user` WHERE `email` = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->bind_result($hashed_password);
    $query->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Successful login
        session_start();
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials
        header("Location: login.php?error=Invalid email or password.");
        exit();
    }

    $query->close();
}*/

$conn->close();
?>
