<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Include navigation bar and other header elements
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="testimonial_add.php" method="post">
        <label for="service_id">Service:</label>
        <select name="service_id" id="service_id" required>
            <option value="">Select a service</option>
            <?php
            // Retrieve services from the database
            $conn = new mysqli("localhost", "username", "password", "database_name");
            $sql = "SELECT service_id, name FROM service";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['service_id'] . "'>" . $row['name'] . "</option>";
                }
            }

            $conn->close();
            ?>
        </select>
        <br>
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        <br>
        <label for="first_name">Parent's First Name:</label>
        <input type="text" name="first_name" id="first_name" required>
        <br>
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required></textarea>
        <br>
        <input type="submit" name="submit" value="Submit Testimonial">
    </form>
</body>
<?php
if (isset($_POST['submit'])) {
    // Process form data
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $first_name = $_POST['first_name'];
    $comment = $_POST['comment'];
    $status = "pending";
    $user_id = $_SESSION['user']['user_id'];

    // Insert into the database
    $sql = "INSERT INTO testimonial (service_id, date, comment, status, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $service_id, $date, $comment, $status, $user_id);
    $stmt->execute();

    // Display a confirmation message
    echo "<p>Your testimonial has been submitted and is awaiting approval.</p>";

    $stmt->close();
    $conn->close();
}
?>

</html>