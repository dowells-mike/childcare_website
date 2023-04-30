<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Parent Login</title>
</head>

<body>
  <?php //include('header.php'); 
  ?>
  <form id="login-form" method="post">
    <input type="text" name="username" id="UserName" class="LoginForm" placeholder="Username">
    <input type="password" name="password" id="password" class="LoginForm" placeholder="Password">
    <input type="submit" value="Login" id="Login">
  </form>
  <p>If not and existing user please <a href="signup.php">Sign up</a> here!</p>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require ('/Applications/XAMPP/connectiontest.php');


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
  // // Check if info is submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    if (!isset($_POST['username']) || empty($_POST['username'])) {
      $errors[] = 'Please enter a valid username';
    } else {
      $uname = htmlentities($_POST['username']);
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
      $errors[] = 'Please enter a valid password';
    } else {
      //store user input
      $pass = htmlentities($_POST['password']);
      if (validate_password($pass)) {
      } else {
        //store error message in array
        $errors[] = 'Password should contain lowercase';
        $errors[] = 'Password should contain uppercase';
        $errors[] = 'Password should contain numbers';
        $errors[] = 'Password should not be less than 8 characters';
      }
    }
    $sql = "SELECT * FROM user WHERE username='$uname' AND password='$pass'";
    $result = mysqli_query($db_connection, $sql);

    if (empty($errors)) {
      if (mysqli_num_rows($result) === 1) {
        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role']=== 'admin') {
          header("Location: parent_signup.php");
            exit();
          } else {
            header("Location: index.php");
            exit(); 
          }
        
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $last = $row['last_name'];
        $first = $row['first_name'];
        echo nl2br(" <div  class='row' >
                  <div  class='left' >
                      <label>User Name:</label> 
                  </div>
                  <div  class='right' >  <label>" . $username . "</label> </div></div>\n");
        echo nl2br(" <div  class='row' >
                  <div  class='left' >
                      <label>Last Name:</label> 
                  </div>
                  <div  class='right' >  <label>" . $last . "</label> </div></div>\n");
        echo nl2br(" <div  class='row' >
                  <div  class='left' >
                      <label>First Name:</label> 
                  </div>
                  <div  class='right' >  <label>" . $first . "</label> </div></div>\n");
      }
    } else {
      echo "<h2>Error!</h2><h3>The following error(s) occurred, Please resubmit your information:</h3>";
      foreach ($errors as $msg) {
        echo "- $msg<br/><br/>";
      }
    }
  }

  ?>
</body>

</html>