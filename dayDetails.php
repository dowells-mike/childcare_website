<!DOCTYPE html>
<html>

<head>
    <title>Childcare Center - Daily Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="header">
        <h1>Childcare Center</h1>
        <p>Daily Details</p>
    </div>

    <div class="content">
        <?php
        // Check if user is logged in
        session_start();
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        // Check user's role
        if ($_SESSION["role"] !== "parent" && $_SESSION["role"] !== "admin") {
            header("Location: login.php");
            exit();
        }

        // Connect to database
        require_once "../../../connection.php";

        // Get parameters from URL
        $child_id = $_GET["child_id"] ?? null;
        $date = $_GET["date"] ?? null;

        // Check if user is authorized to view this child's details
        if ($_SESSION["role"] === "parent" && $_SESSION["child_id"] != $child_id) {
            echo "You are not authorized to view this page";
            exit();
        }

        // Build query based on user's access level and selected filters
        if ($_SESSION["role"] === "admin") {
            // Admin can filter by child and date
            $sql = "SELECT d.*, c.first_name, c.last_name FROM day_detail d JOIN child c ON d.child_id = c.child_id WHERE 1=1";
            if ($child_id) {
                $sql .= " AND d.child_id = " . $child_id;
            }
            if ($date) {
                $sql .= " AND d.date = '" . $date . "'";
            }
            $sql .= " ORDER BY c.first_name ASC";
        } else {
            // Parent can only view their child's details for today
            $sql = "SELECT d.*, c.first_name, c.last_name FROM day_detail d JOIN child c ON d.child_id = c.child_id WHERE d.child_id = " . $_SESSION["child_id"] . " AND d.date_of_birth = CURDATE()";
        }

        // Execute query
        $result = mysqli_query($db_connection, $sql);

        // Check if record exists
        if (mysqli_num_rows($result) == 0) {
            echo "Record not found";
            exit();
        }

        // Build table of results
        $table = "<table class='table'>";
        $table .= "<thead><tr><th>Child Name</th><th>Date of Birth</th><th>Gender</th><th>Categories</th><th>Temperature (&deg;F)</th><th>Breakfast</th><th>Lunch</th><th>Activities</th></tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>";
            $table .= "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
            $table .= "<td>" . $row["date_of_birth"] . "</td>";
            $table .= "<td>" . $row["gender"] . "</td>";
            $table .= "<td>" . $row["categories"] . "</td>";
            $table .= "<td>" . $row["temperature"] . "</td>";
            $table .= "<td>" . $row["breakfast"] . "</td>";
            $table .= "<td>" . $row["lunch"] . "</td>";
            $table .= "<td>" . $row["activities"] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</tbody></table>";

        // Close database connection
        mysqli_close($db_connection);
        ?>

        <?php if ($_SESSION["role"] === "admin") : ?>
            <form method="GET">
                <div class="form-group">
                    <label for="child_id">Filter by Child:</label>
                    <select class="form-control" name="child_id" id="child_id">
                        <option value="">All</option>
                        <?php
                        // Get list of children from database
                        $child_sql = "SELECT * FROM child ORDER BY first_name ASC";
                        $child_result = mysqli_query($conn, $child_sql);
                        while ($child_row = mysqli_fetch_assoc($child_result)) {
                            $selected = $child_row["child_id"] == $child_id ? "selected" : "";
                            echo "<option value='" . $child_row["child_id"] . "' " . $selected . ">" . $child_row["first_name"] . " " . $child_row["last_name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Filter by Date:</label>
                    <input class="form-control" type="date" name="date" id="date" value="<?php echo $date ?>">
                </div>
                <button class="btn btn-primary" type="submit">Filter</button>
            </form>
        <?php endif; ?>

        <?php echo $table ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>