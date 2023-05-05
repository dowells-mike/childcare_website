<?php
session_start();
include 'header.php';
// Connect to the database
require '../../../connection.php';

// Check if the user is logged in and is a parent
if ($_SESSION["role"] != "member") {
    header("Location: index.php");
    exit();
}

// Initialize variables for form validation
$service_id = $date = $comment = '';
$service_id_err = $date_err = $comment_err = '';

// Process the form data and insert it into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate service_id
    if (empty(trim($_POST['service_id']))) {
        $service_id_err = 'Please select a service.';
    } else {
        $service_id = trim($_POST['service_id']);
    }

    // Validate date
    if (empty(trim($_POST['date']))) {
        $date_err = 'Please enter a date.';
    } else {
        $date = trim($_POST['date']);
    }

    // Validate comment
    if (empty(trim($_POST['comment']))) {
        $comment_err = 'Please enter a comment.';
    } else {
        $comment = trim($_POST['comment']);
    }

    // Insert the testimonial into the database if there are no errors
    if (empty($service_id_err) && empty($date_err) && empty($comment_err)) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id']; // Set the user_id value to the current user's ID
            $sql = "INSERT INTO testimonial (date, comment, user_id, service_id) VALUES (?, ?, ?, ?)";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("ssii", $date, $comment, $user_id, $service_id);
            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Testimonial added successfully.";
            } else {
                $_SESSION['error_msg'] = "Error adding testimonial: " . $stmt->error;
            }
        } else {
            $_SESSION['error_msg'] = "Error adding testimonial: User ID is not set.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Testimonial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Add Testimonial</h1>
        <?php
        // Display success or error message if set in the session
        if (isset($_SESSION['success_msg'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_msg'] . '</div>';
            unset($_SESSION['success_msg']);
        }
        if (isset($_SESSION['error_msg'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_msg'] . '</div>';
            unset($_SESSION['error_msg']);
        }
        ?>

        <div class="form-group">
            <label for="parent_name">Parent Name:</label>
            <input type="text" id="parent_name" name="parent_name" class="form-control" value="<?php echo $_SESSION['name']; ?>" disabled>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group <?php echo (!empty($service_id_err)) ? 'has-error' : ''; ?>">
                <label for="service_id">Service:</label>
                <select id="service_id" name="service_id" class="form-control" required>
                    <option value="">Select a service</option>
                    <?php
                    // Retrieve the list of services from the database
                    $sql = "SELECT * FROM service";
                    $result = $db_connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['service_id'] == $service_id) ? 'selected' : '';
                            echo "<option value='" . $row['service_id'] . "' $selected>" . $row['service_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <span class="help-block"><?php echo $service_id_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control" readonly value="<?php echo date('Y-m-d'); ?>" required>
                <span class="help-block"><?php echo $date_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" class="form-control" required><?php echo $comment; ?></textarea>
                <span class="help-block"><?php echo $comment_err; ?></span>
            </div>

            <input type="submit" value="Submit Testimonial" class="btn btn-primary">
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>