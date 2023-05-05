<?php
session_start();
include 'header.php';
// Check if the user is an admin, otherwise redirect to the login page
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
//     header("Location: login.php");
//     exit();
// }
// if ($_SESSION["role"] === "admin") {
//     header("Location: dayDetails.php");
//     exit();
// }

// Include database connection file
require('../../../connection.php');


// Initialize an array to hold error messages
$errors = array();

// Initialize variables for form data
$child_name = '';
$temperature = '';
$breakfast = '';
$lunch = '';
$activities = '';

// Process form data if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Check if the child exists in the child table
    $sql = "SELECT * FROM child WHERE first_name = ? AND last_name = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // The child does not exist in the child table
        $errors[] = "The child does not exist.";
    } else {
        // Fetch the child's information
        $child = $result->fetch_assoc();
        $child_id = $child['child_id'];
        $child_name = $child['first_name'] . ' ' . $child['last_name'];

        // Check if a record exists for the child on the current day
        $date = date('Y-m-d');
        $sql = "SELECT * FROM day_detail WHERE child_id = ? AND date = ?";
        $stmt = $db_connection->prepare($sql);
        $stmt->bind_param("is", $child_id, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // The record exists, so fetch the information
            $day_detail = $result->fetch_assoc();
            $temperature = $day_detail['temperature'];
            $breakfast = $day_detail['breakfast'];
            $lunch = $day_detail['lunch'];
            $activities = $day_detail['activities'];
        }
    }
}

// Update or insert day detail data if the form is submitted again
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // if (isset($_POST['first_name'])) {
    //     $first_name = $_POST['first_name'];
    // }
    // if (isset($_POST['last_name'])) {
    //     $last_name = $_POST['last_name'];
    // }
    if (isset($_POST['child_id'])) {
        $child_id = $_POST['child_id'];
    }
    $temperature = $_POST['temperature'];
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $activities = $_POST['activities'];

    // Validate form data
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
    // Check if the child exists in the child table
    $sql = "SELECT * FROM child WHERE child_id = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // The child does not exist in the child table
        $errors[] = "The child does not exist.";
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Day Details Edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>


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

        <form action="" method="post" novalidate>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" class="form-control" required>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" class="form-control" required>
            </div>
            <button type="submit" name="fetch" class="btn btn-primary">Edit</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch']) && empty($errors)) : ?>
            <hr>
            <form action="" method="post" novalidate>
                <div class="form-group">
                    <label for="child_name">Child Name:</label>
                    <input type="text" name="child_name" id="child_name" class="form-control" value="<?php echo $child_name; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="temperature">Temperature:</label>
                    <input type="text" name="temperature" id="temperature" class="form-control" value="<?php echo $temperature; ?>" required>
                </div>
                <div class="form-group">
                    <label for="breakfast">Breakfast:</label>
                    <input type="text" name="breakfast" id="breakfast" class="form-control" value="<?php echo $breakfast; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lunch">Lunch:</label>
                    <input type="text" name="lunch" id="lunch" class="form-control" value="<?php echo $lunch; ?>" required>
                </div>
                <div class="form-group">
                    <label for="activities">Activities:</label>
                    <input type="text" name="activities" id="activities" class="form-control" value="<?php echo $activities; ?>" required>
                </div>
                <input type="hidden" name="child_id" value="<?php echo $child_id; ?>">
                <button type="submit" name="save" class="btn btn-primary">Save</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Include Bootstrap JS file -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>