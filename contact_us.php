<?php
// Establish database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "s3086994";
$db_connection = mysqli_connect($host, $user, $password, $database);
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Insert form data into database
$stmt = mysqli_prepare($db_connection, "INSERT INTO contact_us_message (name, email, phone_number, message) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone_number, $message);

if (mysqli_stmt_execute($stmt)) {
    echo "Thank you for contacting us!";
} else {
    echo "Error: " . mysqli_error($db_connection);
}

mysqli_stmt_close($stmt);
mysqli_close($db_connection);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
            <h1 class="display-4">Get in touch with our team or make a request.</h1>
        </div>
    </div>
    

    <!-- Contact Us -->
    <div class="container">
        <h1>Contact Us</h1>
        <form action="contact_us.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>