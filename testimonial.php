<!DOCTYPE html>
<html>

<head>
    <title>Testimonials</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    session_start();
    include 'header.php';
    // Connect to the database
    require('../../../connection.php');


    // Retrieve all approved testimonials from the database
    $sql = "SELECT t.*, s.service_name, u.first_name 
FROM testimonial t
JOIN service s ON t.service_id = s.service_id
JOIN user u ON t.user_id = u.user_id
WHERE t.approved = 1
ORDER BY t.date DESC";
    $result = $db_connection->query($sql);
    ?>

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

        <?php
        // Display each testimonial in a formatted way
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
                echo '<div class="panel panel-default">';
                echo '<div class="panel-body">';
                echo '<p><strong>' . (isset($row['first_name']) ? $row['first_name'] : '') . '</strong> on <strong>' . date('F j, Y', strtotime($row['date'])) . '</strong></p>';
                echo '<p><em>Service: ' . (isset($row['service_name']) ? $row['service_name'] : '') . '</em></p>';
                echo '<p>' . $row['comment'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info">No testimonials found.</div>';
        }
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>