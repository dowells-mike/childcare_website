<!DOCTYPE html>
<html>
    <head><link rel="stylesheet" href=""></head>
    <title>Parent Signup</title>
    <body>
    
        <!--create a form-->
    <div class = "content">
        <form  method="post" action="parent_signup.php" novalidate >
            <div  class="row" >
            <div  class="left" >
                <label for="UserName">User Name</label> 
            </div>
            <div  class="right" >
                <input type="text" name="UserName" placeholder="User Name "  required> 
            <?php /*check error requires is not empty*/if (empty($errors[0])){} else echo "<-----".$errors[1];?><br>
            <div  class="row" >
            <div  class="left" >
                <label for="FirstName">First Name</label> 
            </div>
            <div  class="right" >
                 <input type="text" name="Firstname"  placeholder="First Name" required>
            <?php /*check error requires is not empty*/if (empty($errors[1])){} else echo "<-----".$errors[1];?><br>
            <div  class="row" >
            <div  class="left" >
                <label for="LastName">Last Name</label> 
            </div>
            <div  class="right" >
                 <input type="text" name="LastName" placeholder="Last Name"  required>
            <?php /*check error requires is not empty*/if (empty($errors[2])){} else echo "<-----".$errors[1];?><br>
            <div  class="row" >
            <div  class="left" >
                <label for="Password">Password</label> 
            </div>
            <div  class="right" >
                <input type="password" name="Password" placeholder="Password" required>
            <?php /*check error requires is not empty*/if (empty($errors[3])){} else echo "<-----".$errors[1];?><br>
            </div>
            <div  class="row" >
            <div  class="left" >
                <label for="Phone Number">Phone Number</label> 
            </div>
            <div  class="right" >
                <input type="number" name="phone" placeholder="Phone Number" required>
            <?php /*check error requires is not empty*/if (empty($errors[4])){} else echo "<-----".$errors[1];?><br>
            </div>
            <div  class="row" >
            <div  class="left" >
                <label for="email">Email</label> 
            </div>
            <div  class="right" >
                <input type="text" name="email" placeholder="Email" required>
            <?php /*check error requires is not empty*/if (empty($errors[5])){} else echo "<-----".$errors[1];?><br>
            </div>

            <br><br><br>
            <br><br><br>
        <div class="search">
            <input type="submit" value="Signup" class="register">
            <br><br>
            <button><a href="test.html">Else Return Home</a></button>
        </div>
        </form>
    </div>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member = "member";

    if (!isset($_POST['UserName']) || empty($_POST['UserName'])) {
      $errors[0] = 'Please enter a valid username';
    }
    else {
        $Uname = $_POST['UserName'];
    }

    $sql = "SELECT * FROM user WHERE username = '$Uname'";
    $result = mysqli_query($db_connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors[1] = "the User Name $Uname already exists.";
    }

    if (!isset($_POST['Firstname']) || empty($_POST['Firstname'])) {
        $errors[] = 'Please enter a valid first name';
      }
      else {
        $Fname = $_POST['Firstname'];
    }

    if (!isset($_POST['LastName']) || empty($_POST['LastName'])) {
    $errors[] = 'Please enter a valid first name';
    }
    else {
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
        $errors[] = 'Please enter a valid password';
      } else {
        //store user input
        $Password = $_POST['Password'];
        if (validate_password($Password)) {
        } else {
          //store error message in array
          $errors[] = 'Password should contain lowercase';
          $errors[] = 'Password should contain uppercase';
          $errors[] = 'Password should contain numbers';
          $errors[] = 'Password should not be less than 8 characters';
        }
      }
      function validate_phone($phone){
        if(preg_match('/^[0-9]{10}+$/', $phone)) {
            return true;
        } else {
            return false;
            }
    }

    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors[] = 'Please enter a valid phone Number';
    } else {
        $phone = $_POST['phone'];
        if (validate_phone($phone)) {
        }
        else {
            $errors[] = 'Phone Number must be at least 10 digits';
        }
    }

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
     }

     if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors[] = 'Please enter a valid email address';
    } else {
        $email = $_POST['email'];
    }

    if (empty($errors)) {
        $query = "INSERT INTO user (first_name,last_name,username,password,role,phone_number,email)
                   VALUES ('$Fname','$Lname','$Uname','$Password','$member','$phone','$email')";
        $result= mysqli_query($db_connection,$query);
        if ($result) {
            $id = mysqli_insert_id($db_connection);
            echo '<script type="text/javascript">
                window.onload = function () { alert("succesfully created account."); } 
                </script>';
            header("Location: index.php");
            exit;
            
        } else {
            mysqli_close($db_connection);
            $errors[] = "Error inserting Member: " . mysqli_error($db_connection);
        }
    }
    else {
        echo "<h2>Error!</h2><h3>The following error(s) occurred, Please resubmit your information:</h3>";
        foreach ($errors as $msg) {
          echo "- $msg<br/><br/>";
        }
      }
     
    }
    ?>
    </body>
</html>
        