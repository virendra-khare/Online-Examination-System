<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homw</title>
    <link rel="stylesheet" href="public/css/body.css">
    <link rel="stylesheet" href="public/css/nav.css">
    <link rel="stylesheet" href="public/css/front-page.css">
    <link rel="stylesheet" href="public/css/contact.css">
    <link rel="stylesheet" href="public/css/notification.css">
    <link rel="stylesheet" href="public/css/notice_board.css">
    <link rel="stylesheet" href="public/css/footer.css">
    <script src="public/js/nav.js"></script>
</head>
<body>
<!-- Navigation Bar Section Start -->
<header>
  <div class="container-1">
    <div class="logo" style="width: auto;">
      <figure><a href="#demo-1"><img src="public/images/tactic_23dp_000000_FILL0_wght400_GRAD0_opsz24.svg" alt="logo"></a></figure>
    </div>
    <div class="content">
      <a href="#demo-2"><h1 style="color: #3F00FF;">Whiteroom</h1></a>
    </div>
  </div>
  <nav>
    <a href="#exams">Exam</a>
    <a href="#contact">Contact</a>
    <a href="public/views/student-dashboard.php">About</a>
    <div class="dropdown">
        <button class="dropbtn">Login 
          <i class="fa fa-caret-down"></i>
        </button>
      <div class="dropdown-content">
        <a href="public/views/user-student.html">Studend</a>
        <a href="public/views/admin-login.html">Admin</a>
        <a href="public/views/head-login.html">Head</a>
      </div>
    </div>
  </nav>
  <div class="menu">
    <div class="container" onclick="myFunction(this)">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
  </div>
</header>   
<!--Side Nav Seciton is pending-->
    <div id="side-nav" class="side-nav">
      <div class="link"><a href="">Exam</a></div>
      <div class="link"><a href="#contact">Contact</a></div>
      <div class="link"><a href="">About</a></div>
      <div class="link">
      <div class="dropdown">
          <a>Login 
            <i class="fa fa-caret-down"></i> <!--Drop down icon-->
          </a>
        <div class="dropdown-content">
        <a href="public/views/user-student.html">Studend</a>
        <a href="public/views/user-college.html">College</a>
        <a href="public/views/user-university.html">University</a>
        </div>
      </div>
    </div>
    </div>
<!-- Navigation Bar Section End -->

<!-- Front Page Start -->
<div class="front-container1 front-common">
    <div class="front-logo">
           <figure><img src="public/images/WhatsApp Image 2024-12-21 at 4.00.45 PM.jpeg" alt="Logo"></figure>
    </div>
    <div class="front-content-section front-common">
        <div class="heading"><h1>A Little Bit about US.</h1></div>
        <div class="discription">
           <p style="color: #111;"><b>[Whiteroom]</b> specializes in delivering cutting-edge web application development and comprehensive IT services.
                Our expertise includes custom software solutions, website design, mobile app development, cloud integration, and IT consulting. We empower businesses with innovative, secure, and scalable technology to drive growth and efficiency.</p>
        </div>
    </div>
</div>
<!-- Front Page End -->

<!-- Notification Section Start -->
    <!-- Currently Design is not ready. So we work on it letter. -->
<!-- Notification Section End -->


<!-- Exam SECTION Start -->
<div class="notification-box">
        <h2 id="exams">Exams</h2>
    <div style="overflow-x: auto;">
        <table>
            <tr>
                <th>Class</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Last Date</th>
                <th>Instruction</th>
                <th>Join</th>
              <tr>
                <td>Jill</td>
                <td>Smith</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
              </tr>
              <tr>
                <td>Eve</td>
                <td>Jackson</td>
                <td>94</td>
                <td>94</td>
                <td>94</td>
                <td>94</td>
              </tr>
              <tr>
                <td>Adam</td>
                <td>Johnson</td>
                <td>67</td>
                <td>67</td>
                <td>67</td>
                <td>67</td>
              </tr>
        </table>
      </div>
    </div> 
<!-- Exam SECTION End -->


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


<!-- CONTACT SECTION START -->
<div class="contact-container-1" id="contact">
  <div class="contact-form">
    <h1 id="heading" style="text-align: left;">Contact</h1>
        <h4>Description.</h4>
            <form action="server/feedback.php" method="post">
                <div class="pair">
                    <div class="form-input"><input type="text" name="name" placeholder="Full Name:"></div>
                </div>
                <div class="pair">
                    <div class="form-input"><input type="text" name="email" placeholder="E-mail:"></div>
                </div>
                <div class="pair">
                    <div class="form-input"><input type="text" name="subject" placeholder="Subject:"></div>
                </div>
                <div class="pair">
                    <div class="form-input">
                    <textarea class="message" rows="4" cols="50" name="message" placeholder="Message..."></textarea>
                    </div>
                </div>
         
                <div class="contact-form-submit-btn">
                    <span><input type="submit" name="register"></span>
                </div>
            </form>
    </div>
</div>
<!-- CONTACT SECTION END -->

<!-- Footer Section Start -->
<footer>
        <div class="footer-container1">
            <div class="footer-container2">
                    <div class="footer-heading">
                        <h1>Whiteroom</h1>
                    </div>
                    <div class="discription">
                        <p style="width: 400px; text-align: justify;"><b>[Concure]</b> the world.</p>
                    </div>
            </div>
            <div class="footer-container2" style="padding-top: 30px; padding-left: 15px;">
                <div class="footer-heading">
                    <h3>Services</h3>
                </div>
                <div class="discription">
                <div class="footer-link">
                    <a href="#">Link1</a> 
                </div>
                <div class="footer-link"> <a href="#">Link2</a></div> 
                <div class="footer-link"> <a href="#">Link3</a></div>
                </div>
                
            </div>
            <div class="footer-container2" style="padding-top: 30px; padding-left: 15px;">
            <div class="footer-heading">
                <h3>About</h3>
            </div>
            <div class="discription">
            <div class="footer-link">
                <a href="#">Link1</a> 
            </div>
            <div class="footer-link"> <a href="#">Link2</a></div> 
            <div class="footer-link"> <a href="#">Link3</a></div>
            </div>
            
        </div>
        </div>
        <hr style="width: 90%;">
        <br>
        <div class="footer-containter3">
            <div class="footer-content-link">
            <div class="footer-link">
                <p>Privecy Policu</p>
            </div>
            <div class="footer-link">
                <p>Terms & Conditions</p>
            </div>
            </div>
            <div class="social-link">
                <a href="#">
                    <img src="public/images/linkedin-color-svgrepo-com.svg" style="width: 24px; height: 24px;" alt="">
                </a>

                <a href="#Youtube">
                    <img src="public/images/youtube-svgrepo-com.svg" style="width: 30px; height: 30px;"  alt="">
                </a>

                <a href="#Youtube">
                    <img src="public/images/github-svgrepo-com.svg" style="width: 30px; height: 30px;"  alt="">
                </a>
            </div>
        </div>
</footer>
<!-- Footer Section End -->
</body>
</html>