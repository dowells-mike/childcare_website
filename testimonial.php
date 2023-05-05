<?php
// Start session and connect to the database
session_start();
require ('/Applications/XAMPP/connectiontest.php');


// Check if the user is an admin
$isAdmin = false;
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $isAdmin = true;
}

// Add testimonial if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isAdmin) {
    $serviceName = $_POST['service_name'];
    $date = $_POST['date'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO testimonial (service_id, date, user_id, comment) VALUES ((SELECT service_id FROM service WHERE name=?), ?, (SELECT user_id FROM user WHERE first_name=? AND last_name=?), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $serviceName, $date, $firstName, $lastName, $comment);
    $stmt->execute();
}

// Approve testimonial
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $isAdmin && isset($_GET['approve'])) {
    $testimonialId = $_GET['approve'];

    $sql = "UPDATE testimonial SET is_approved = 1 WHERE testimonial_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $testimonialId);
    $stmt->execute();
}

// Get approved and unapproved testimonials
$sql = "SELECT t.testimonial_id, s.name AS service_name, t.date, u.first_name, u.last_name, t.comment, t.is_approved FROM testimonial t JOIN user u ON t.user_id = u.user_id JOIN service s ON t.service_id = s.service_id";
$approvedResult = $conn->query($sql . " WHERE t.is_approved = 1");
$unapprovedResult = $conn->query($sql . " WHERE t.is_approved = 0");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Testimonials</title>
    <!-- Add your CSS styling here -->
</head>

<body>

    <header>
        <!-- Add your navigation bar and login/logout functionality here -->
    </header>

    <main>
        <h1>Testimonials</h1>

        <?php if ($isAdmin) : ?>
            <h2>Add Testimonial</h2>
            <form method="post" action="testimonial.php">
                <label for="service_name">Service Name:</label>
                <input type="text" name="service_name" id="service_name" required><br>
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required><br>
                <label for="first_name">User's First Name:</label>
                <input type="text" name="first_name" id="first_name" required><br>
                <label for="last_name">User's Last Name:</label>
                <input type="text" name="last_name" id="last_name" required><br>
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" required></textarea><br>
                <input type="submit" value="Add Testimonial">
            </form>
        <?php endif; ?>

        <?php if ($unapprovedResult->num_rows > 0) : ?>
            <h2>Unapproved Testimonials</h2>
            <table>
                <tr>
                    <th>Service Name</th>
                    <th>Date</th>
                    <th>User's Name</th>
                    <th>Comment</th>
                    <?php if ($isAdmin) : ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>

                <?php while ($row = $unapprovedResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                        <?php if ($isAdmin) : ?>
                            <td>
                                <a href="testimonial.php?approve=<?php echo $row['testimonial_id']; ?>">Approve</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>

        <?php if ($approvedResult->num_rows > 0) : ?>
            <h2>Approved Testimonials</h2>
            <table>
                <tr>
                    <th>Service Name</th>
                    <th>Date</th>
                    <th>User's Name</th>
                    <th>Comment</th>
                </tr>

                <?php while ($row = $approvedResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </main>

</body>

</html>