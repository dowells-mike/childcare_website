<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>
    <?php
    require("session.php");

    include('header.php');
    ?>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['firstname']) || empty($_POST['firstname'])) {
            $errors[0] = 'Please enter a valid First Name';
        } else {
            $fname = $_POST['firstname'];
        }
        if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
            $errors[1] = 'Please enter a valid last Name';
        } else {
            $lname = $_POST['lastname'];
        }
        if (!isset($_POST['DOB']) || empty($_POST['DOB'])) {
            $errors[2] = 'Please enter a valid birthday';
        } else {
            $dob = $_POST['DOB'];
        }
        if (!isset($_POST['gender']) || empty($_POST['gender'])) {
            $errors[3] = 'Please select a gender';
        } else {
            $gender = $_POST['gender'];
        }
        if (!isset($_POST['category']) || empty($_POST['category'])) {
            $errors[4] = 'Please select a valid category';
        } else {
            $category = $_POST['category'];
        }
        if (!isset($_POST['duration']) || empty($_POST['duration'])) {
            $errors[5] = 'Please select a valid duration';
        } else {
            $duration = $_POST['duration'];
        }

        if (empty($errors)) {
            $userID = $_SESSION["userid"];
            $query = "INSERT INTO child (first_name,last_name,date_of_birth,gender,categories,user_id,fee_id)
            VALUES ('$fname','$lname','$dob','$gender','$category','$userID','$duration')";
            $result = mysqli_query($db_connection, $query);
            if ($result) {
                $id = mysqli_insert_id($db_connection);
                header("Location: registration.php");
            } else {
                mysqli_close($db_connection);
                $errors[] = "Error inserting Member: " . mysqli_error($db_connection);
            }
        }
    }
    ?>
    <h3>Please use the Fee infromation to select child duration</h3>
    <table width="100%" border=1px solid black style="border-collapse:collapse;">
        <thead>
            <tr>
                <th><strong>FEE</strong></th>
                <th><strong>DURATION</strong></th>
            </tr>
        </thead>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $query = "SELECT * FROM FEE ORDER BY fee_id";
        $result = mysqli_query($db_connection, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td align="center"><?php echo $row["fee"]; ?></td>
                <td align="center"><?php echo $row["duration"]; ?></td>
            </tr>
        <?php  } ?>
        </tbody>
    </table>
    <form method="post" novalidate>
        <h1>REGISTER CHILD</h1>
        <br><br>

        <label for="firstname">First Name</label>
        <input type="text" name="firstname" placeholder="First Name" value="<?php echo @$_POST['firstname']; ?>" required>
        <span class="error">* <?php if (empty($errors[0])) {
                                } else echo "<br>" . $errors[0]; ?></span>
        <br>

        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" placeholder="Last Name" value="<?php echo @$_POST['lastname']; ?>" required>
        <span class="error">* <?php if (empty($errors[1])) {
                                } else echo "<br>" . $errors[1]; ?></span>
        <br>

        <label for="birthday">Date of Birth</label>
        <input type="date" name="DOB" value="<?php echo @$_POST['date']; ?>" required>
        <span class="error">* <?php if (empty($errors[2])) {
                                } else echo "<br>" . $errors[2]; ?></span>
        <br>

        <label for="gender">Gender</label>
        <select name="gender">
            <!--select options-->
            <option value=""><?php echo @$_POST['gender']; ?></option>
            <option value="male">
                male</option>
            <option value="female">
                female</option>
        </select>
        <span class="error">* <?php if (empty($errors[3])) {
                                } else echo "<br>" . $errors[3]; ?></span>
        <br>

        <label for="category">category</label>
        <select name="category">
            <!--select options-->
            <option value=""><?php echo @$_POST['category']; ?></option>
            <option value="babies">
                babies</option>
            <option value="wobblers">
                wobblers</option>
            <option value="toddlers">
                toddlers</option>
            <option value="preschool">
                Pre-School</option>
        </select>
        <span class="error">* <?php if (empty($errors[4])) {
                                } else echo "<br>" . $errors[4]; ?></span>
        <br>

        <label for="duration">Duration</label>
        <select name="duration">
            <!--select options-->
            <option value=""><?php echo @$_POST['duration']; ?></option>
            <option value="1">
                HALF DAY</option>
            <option value="2">
                FULL DAY</option>
            <option value="3">
                TWO DAYS</option>
            <option value="4">
                THREE DAYS</option>
            <option value="5">
                FIVE DAYS</option>
            <option value="6">
                WEEKEND</option>
        </select>
        <span class="error">* <?php if (empty($errors[5])) {
                                } else echo "<br>" . $errors[5]; ?></span>
        <br><br>

        <input type="submit" onclick="myfunction()" value="Register" class="register">
        <script>
            function myfunction() {
                if (alert("Confirming details . please click close for next action👍")) {
                    header("Location: index.php");
                    exit;
                }
            }
        </script>
    </form>

</body>

</html>