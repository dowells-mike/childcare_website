<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
</head>

<body>

    <?php
    session_start();
    include('header.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $member = "admin";
        if (!isset($_POST['UserName']) || empty($_POST['UserName'])) {
            $errors[0] = 'Please enter a valid username <br><br>';
        } else {
            $Uname = $_POST['UserName'];
        }

        $sql = "SELECT * FROM user WHERE username = '$Uname'";
        $result = mysqli_query($db_connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors[0] = "the User Name $Uname already exists.<br><br>";
        }

        if (!isset($_POST['Firstname']) || empty($_POST['Firstname'])) {
            $errors[1] = 'Please enter a valid first name<br><br>';
        } else {
            $Fname = $_POST['Firstname'];
        }

        if (!isset($_POST['LastName']) || empty($_POST['LastName'])) {
            $errors[2] = 'Please enter a valid Last name<br><br>';
        } else {
            $Lname = $_POST['LastName'];
        }
        function validate_password($password)
        {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);

            if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
                // tell the user something went wrong
                return false;
            } else {
                return true;
            }
        }
        if (!isset($_POST['Password']) || empty($_POST['Password'])) {
            $errors[3] = 'Please enter a valid password<br><br>';
        } else {
            //store user input
            $Password = $_POST['Password'];
            $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
            if (validate_password($Password)) {
            } else {
                //store error message in array
                $errors[3] = 'Password should contain lowercase <br> Password should contain uppercase <br> 
          Password should contain numbers <br> Password should not be less than 8 characters<br><br> ';
            }
        }
        if (!isset($_POST['confirm-Password']) || empty($_POST['confirm-Password'])) {
            $errors[3] = 'Please enter a valid password<br><br>';
        } else {
            $cpass = $_POST['confirm-Password'];
            if ($cpass == $Password){
            }else{
                $errors[3] = 'Passwords do not match<br><br>';
            }
        }
        function validate_phone($phone)
        {
            if (preg_match('/^[0-9]{10}+$/', $phone)) {
                return true;
            } else {
                return false;
            }
        }

        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            $errors[4] = 'Please enter a valid phone Number<br><br>';
        } else {
            $phone = $_POST['phone'];
            if (validate_phone($phone)) {
            } else {
                $errors[4] = 'Phone Number must be at least 10 digits<br><br>';
            }
        }

        function validateEmail($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[5] = 'Please enter a valid email address<br><br>';
        } else {
            $email = $_POST['email'];
            if (validateEmail($email)) {
            } else {
                $errors[5] = 'invalid email format<br><br>';
            }
        }
        if (empty($errors)) {
            $query = "INSERT INTO user (first_name,last_name,username,password,role,phone_number,email)
                   VALUES ('$Fname','$Lname','$Uname','$hashed_password','$member','$phone','$email')";
            $result = mysqli_query($db_connection, $query);
            if ($result) {
                $id = mysqli_insert_id($db_connection);
                $subject = "Account created";
                $message = "Welcome $Uname, You have successfully created an account to be a member of our community.";
                mail($email, $subject, $message);
                header("Location: index.php");
                exit;
                echo "$message";
            } else {
                mysqli_close($db_connection);
                $errors[] = "Error inserting Member: " . mysqli_error($db_connection);
            }
        }
    }

    ?>
    <div class="content">
        <form action="admin_signup.php" method="post" novalidate>
            <h1>Sign-up Page</h1>
            <p><em> * required fields</em></p>
            <div class="row">
                <div class="left">
                    <label for="UserName">User Name</label>
                </div>
                <div class="right">
                    <input type="text" name="UserName" placeholder="User Name" value="<?php echo @$_POST['UserName']; ?>" required>
                    <span class="error">* <?php if (empty($errors[0])) {
                                            } else echo "<br>" . $errors[0]; ?></span>
                    <br>
                    <div class="row">
                        <div class="left">
                            <label for="FirstName">First Name</label>
                        </div>
                        <div class="right">
                            <input type="text" name="Firstname" placeholder="First Name" value="<?php echo @$_POST['Firstname']; ?>" required>
                            <span class="error">* <?php if (empty($errors[1])) {
                                                    } else echo "<br>" . $errors[1]; ?></span>
                            <div class="row">
                                <div class="left">
                                    <label for="LastName">Last Name</label>
                                </div>
                                <div class="right">
                                    <input type="text" name="LastName" placeholder="Last Name" value="<?php echo @$_POST['LastName']; ?>" required>
                                    <span class="error">* <?php if (empty($errors[2])) {
                                                            } else echo "<br>" . $errors[2]; ?></span>
                                    <div class="row">
                                        <div class="left">
                                            <label for="Password">Password</label>
                                        </div>
                                        <div class="right">
                                            <input type="password" name="Password" placeholder="Password" value="<?php echo @$_POST['Password']; ?>" required>
                                            <span class="error">* <?php if (empty($errors[3])) {
                                                                    } else echo "<br>" . $errors[3]; ?></span>
                                        </div>
                                        <div class="row">
                                        <div class="left">
                                            <label for="confirm-Password">Confirm-Password</label>
                                        </div>
                                        <div class="right">
                                            <input type="password" name="confirm-Password" placeholder="confirm Password" required>
                                            <span class="error">* <?php if (empty($errors[3])) {
                                                                    } else echo "<br>" . $errors[3]; ?></span>
                                        </div>
                                        <div class="row">
                                            <div class="left">
                                                <label for="Phone Number">Phone Number</label>
                                            </div>
                                            <div class="right">
                                                <input type="number" name="phone" placeholder="Phone Number" value="<?php echo @$_POST['phone']; ?>" required>
                                                <span class="error">* <?php if (empty($errors[4])) {
                                                                        } else echo "<br>" . $errors[4]; ?></span>
                                            </div>
                                            <div class="row">
                                                <div class="left">
                                                    <label for="email">Email</label>
                                                </div>
                                                <div class="right">
                                                    <input type="text" name="email" placeholder="Email" value="<?php echo @$_POST['email']; ?>" required>
                                                    <span class="error">* <?php if (empty($errors[5])) {
                                                                            } else echo "<br>" . $errors[5]; ?></span>
                                                </div>
                                                <br><br><br>
                                                <div class="search">
                                                    <input type="submit" onclick="myfunction()" value="Sign-up" class="register">
                                                    <script>
                                                        function myfunction() {
                                                            if (alert("Confirming details 👍. please click close for next action")) {
                                                                header("Location: index.php");
                                                                exit;
                                                            }
                                                        }
                                                    </script>
                                                    <br><br>
                                                </div>
        </form>
    </div>
</body>

</html>