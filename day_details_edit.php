<?php
session_start();

// Check if the user is an admin, otherwise redirect to the login page
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: login.php");
    exit();
}

// Include database connection file
include '../../../connection.php';

// Initialize an array to hold error messages
$errors = array();

// Process form data if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $child_name = $_POST['child_name'];
    $temperature = $_POST['temperature'];
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $activities = $_POST['activities'];
    $child_id = $_POST['child_id'];

    // Validate form data
    if (empty($child_name)) {
        $errors[] = "Child name is required.";
    }
    if (empty($temperature)) {
        $errors[] = "Temperature is required.";
    } else if (!is_numeric($temperature)) {
        $errors[] = "Temperature must be a number.";
    }
    if (empty($breakfast)) {
        $errors[] = "Breakfast is required.";
    }
    if (empty($lunch)) {
        $errors[] = "Lunch is required.";
    }
    if (empty($activities)) {
        $errors[] = "Activities are required.";
    }
    // Check if the child_id exists in the child table
    $sql = "SELECT * FROM child WHERE child_id = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // The child_id does not exist in the child table
        $errors[] = "The child_id does not exist.";
    }

    // Check if there are any errors before processing the data
    if (empty($errors)) {
        // Check if a record already exists for the child on the current day
        $date = date('Y-m-d');
        $sql = "SELECT * FROM day_detail WHERE child_id = ? AND date = ?";
        $stmt = $db_connection->prepare($sql);
        $stmt->bind_param("is", $child_id, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing record
            $sql = "UPDATE day_detail SET temperature = ?, breakfast = ?, lunch = ?, activities = ? WHERE child_id = ? AND date = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("ssssis", $temperature, $breakfast, $lunch, $activities, $child_id, $date);
        } else {
            // Insert new record
            $sql = "INSERT INTO day_detail (child_id, date, temperature, breakfast, lunch, activities) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("isssss", $child_id, $date, $temperature, $breakfast, $lunch, $activities);
        }

        if ($stmt->execute()) {
            $message = "Information has been saved.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Day Details Edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Edit Day Details</h1>

        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>

        <?php if (!empty($errors)) : ?>
            <div class='alert alert-danger'>
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="day_details_edit.php" method="post" novalidate>
            <div class="form-group">
                <label for="child_id">Child ID:</label>
                <input type="text" name="child_id" id="child_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="child_name">Child Name:</label>
                <input type="text" name="child_name" id="child_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="temperature">Temperature:</label>
                <input type="text" name="temperature" id="temperature" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="breakfast">Breakfast:</label>
                <input type="text" name="breakfast" id="breakfast" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lunch">Lunch:</label>
                <input type="text" name="lunch" id="lunch" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="activities">Activities:</label>
                <input type="text" name="activities" id="activities" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- Include Bootstrap JS file -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>