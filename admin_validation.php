<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
</head>
<body>
    <form action="" method="post">
        <label>Company password</label>
        <input type="password" name = "company_password" placeholder="company password" required> 
    </form>
    <?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['company_password']) || empty($_POST['company_password'])) {
            $errors[] = 'Please enter the valid password';
        }else{
            $cpass = $_POST['company_password'];
            if ($cpass === "childcare") {
                header("location: admin_signup.php");
                exit;
            }
            else{
                echo "incorrect password, please try again or if not an admin try parent login";
            }
        }
    }
    ?>

</body>
</html>