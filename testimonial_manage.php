<?php
session_start();
include 'header.php';
// Connect to the database
require '../../../connection.php';

// Check if the user is logged in and is an admin or a teacher
if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "teacher") {
    header("Location: index.php");
    exit();
}

// Update the approval status of the testimonial
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['testimonial_id']) && isset($_POST['approved'])) {
        $testimonial_id = $_POST['testimonial_id'];
        $approved = $_POST['approved'];
        $approved_by = $_SESSION['user_id'];

        $sql = "UPDATE testimonial SET approved = ? WHERE testimonial_id = ?";
        $stmt = $db_connection->prepare($sql);
        $stmt->bind_param("ii", $approved, $testimonial_id);
        if ($stmt->execute()) {
            if ($approved) {
                $_SESSION['success_msg'] = "Testimonial approved successfully.";
            } else {
                $_SESSION['success_msg'] = "Testimonial disapproved successfully.";
            }
        } else {
            $_SESSION['error_msg'] = "Error updating testimonial: " . $stmt->error;
        }
    }
}

// Retrieve the list of testimonials from the database
$sql = "SELECT * FROM testimonial";
$result = $db_connection->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Testimonials</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Testimonials</h1>
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Parent Name</th>
                    <th>Comment</th>
                    <th>Approval Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Get the service name
                        $sql_service = "SELECT service_name FROM service WHERE service_id = " . $row['service_id'];
                        $result_service = $db_connection->query($sql_service);
                        $service_name = ($result_service->num_rows > 0) ? $result_service->fetch_assoc()['service_name'] : '';

                        // Get the parent name
                        $sql_user = "SELECT first_name FROM user WHERE user_id = " . $row['user_id'];
                        $result_user = $db_connection->query($sql_user);
                        $parent_name = ($result_user->num_rows > 0) ? $result_user->fetch_assoc()['first_name'] : '';

                        // Display the testimonial details
                        echo "<tr>";
                        echo "<td>" . $service_name . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $parent_name . "</td>";
                        echo "<td>" . $row['comment'] . "</td>";
                        echo "<td>";
                        if ($row['approved']) {
                            echo "<span class='label label-success'>Approved</span>";
                        } else {
                            echo "<span class='label label-danger'>Not Approved</span>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if ($row['approved']) {
                            echo "<form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return confirm(\"Are you sure you want to disapprove this testimonial?\")'>";
                            echo "<input type='hidden' name='testimonial_id' value='" . $row['testimonial_id'] . "'>";
                            echo "<input type='hidden' name='approved' value='0'>";
                            echo "<button type='submit' class='btn btn-danger'>Disapprove</button>";
                            echo "</form>";
                        } else {
                            echo "<form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return confirm(\"Are you sure you want to approve this testimonial?\")'>";
                            echo "<input type='hidden' name='testimonial_id' value='" . $row['testimonial_id'] . "'>";
                            echo "<input type='hidden' name='approved' value='1'>";
                            echo "<button type='submit' class='btn btn-success'>Approve</button>";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No testimonials found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>