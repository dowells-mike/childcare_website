<?php
//set smtp server and port (TO BE FIXED)
//ini_set('SMTP', 'localhost');
//ini_set('smtp_port', 25);

// Start session and require login
session_start();
//require_once '../../session.php';

// Establish database connection
require_once '../../connection.php';

// Function to sanitize form data
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get form data and sanitize
$name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
$phone_number = isset($_POST['phone-num']) ? sanitize($_POST['phone-num']) : '';
$message = isset($_POST['message']) ? sanitize($_POST['message']) : '';

// Validate form data
$errors = array();
if (empty($name)) {
    $errors[] = "Please enter your name.";
}
if (empty($email)) {
    $errors[] = "Please enter your email.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}
if (empty($phone_number)) {
    $errors[] = "Please enter your phone number.";
} elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone_number)) {
    $errors[] = "Please enter a valid phone number in the format xxx-xxx-xxxx.";
}
if (empty($message)) {
    $errors[] = "Please enter a message.";
}

// If there are errors, display them in a warning box
if (!empty($errors)) {
    echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
} else {
    // Insert form data into database
    $stmt = mysqli_prepare($db_connection, "INSERT INTO s3086994.contact_us_message (name, email, phone_number, message) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone_number, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Thank you for contacting us!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($db_connection) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($db_connection);

// Send email to user
$to = $email;
$subject = "Thank you for contacting us!";
$message = "Dear " . $name . ",\n\nThank you for contacting us. We will get back to you as soon as possible.\n\nBest regards,\nThe Childcare team";
$headers = "From: mikedowells400@gmail.com" . "\r\n" .
    "Reply-To: mikedowells400@gmail.com" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

mail($to, $subject, $message, $headers);
?>




<!-- Website Main Content -->
<!DOCTYPE html>
<html lang="en">

<head>
    <<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets-footer/footer.css">
    <link rel="stylesheet" href="assets_contact_us/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets_contact_us/css/aos.min.css">
</head>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Childcare Premises</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services and Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="testimonial.php">Testimonials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_level'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Welcome,
                            <?php echo $_SESSION['username']; ?>!
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!--Banner welcoming the user to contact us page in big text-->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Get in touch with our team or make any inquiries.</h1>
        </div>
    </div>
    

    <!-- Contact Us -->
    
     <section class="py-4 py-xl-5" style="opacity: 1;filter: blur(0px);backdrop-filter: opacity(1);-webkit-backdrop-filter: opacity(1);background: url(&quot;assets/img/top-view-blue-monday-concept-composition-with-telephone%20(1).jpg&quot;) top / cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-7 offset-md-0" style="border-radius: 10px;"><iframe class="shadow" allowfullscreen="" frameborder="0" loading="lazy" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDi7S_7G_eMitxm5bu-gYw6biq9eWhaTXI&amp;q=Dublin%2C+Ireland&amp;zoom=11" data-bss-disabled-mobile="true" data-aos="fade-right" data-aos-duration="600" data-aos-delay="100" width="100%" height="100%" style="padding-right: 0px;margin-right: 0px;"></iframe></div>
                <div class="col-md-5 col-lg-5 col-xl-4" style="box-shadow: inset 0px 0px 2px 0px;--bs-light: #ffffff;--bs-light-rgb: 255,255,255;backdrop-filter: hue-rotate(0deg);-webkit-backdrop-filter: hue-rotate(0deg);filter: blur(0px);background: rgba(213,217,249,0.42);border-radius: 10px;text-shadow: 0px 0px 1px;">
                    <div>
                        <!-- Contact Us Form using post method-->
                        <form class="p-3 p-xl-4" method="post" action="contact_us.php" enctype="multipart/form-data">
                            <h1 style="font-weight: bold;filter: blur(0px);">Contact us</h1>
                            <p class="text-muted">Thank you for visiting our website. Please feel free to reach out to us via the form below with any questions or concerns you may have.</p>
                            <div class="mb-3"><label class="form-label" for="name">Name</label><input class="border rounded-pill form-control" type="text" id="name" name="name" placeholder="Enter your name here..."></div>
                            <div class="mb-3"><label class="form-label" for="phone-num">Phone</label><input class="border rounded-pill form-control" type="tel" id="phone-num" name="phone-num" placeholder="e.g.  999-999-9999"></div>
                            <div class="mb-3"><label class="form-label" for="email">Email</label><input class="border rounded-pill form-control" type="email" id="email" name="email" placeholder="example@email.com"></div>
                            <div class="mb-3"><label class="form-label" for="message">Message</label><textarea class="form-control" id="message" name="message" rows="6" placeholder="Enter your message here..."></textarea></div>
                            <div class="mb-3"><button class="btn btn-primary" type="submit">Send </button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Javascript files called -->
    <script src="assets_contact_us/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets_contact_us/js/aos.min.js"></script>
    <script src="assets_contact_us/js/bs-init.js"></script>
<?php include 'footer.php'; ?>