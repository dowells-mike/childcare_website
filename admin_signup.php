<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
</head>
<body>
<div class = "content">
        <form  method="post"  >
            <div  class="row" >
            <div  class="left" >
                <label for="UserName">User Name</label> 
            </div>
            <div  class="right" >
                <input type="text" name="UserName" placeholder="User Name "  required> 
            <div  class="row" >
            <div  class="left" >
                <label for="FirstName">First Name</label> 
            </div>
            <div  class="right" >
                 <input type="text" name="Firstname"  placeholder="First Name" required>
            
            <div  class="row" >
            <div  class="left" >
                <label for="LastName">Last Name</label> 
            </div>
            <div  class="right" >
                 <input type="text" name="LastName" placeholder="Last Name"  required>
            
            <div  class="row" >
            <div  class="left" >
                <label for="Password">Password</label> 
            </div>
            <div  class="right" >
                <input type="password" name="Password" placeholder="Password" required>
            </div>
            <div  class="row" >
            <div  class="left" >
                <label for="Phone Number">Phone Number</label> 
            </div>
            <div  class="right" >
                <input type="number" name="phone" placeholder="Phone Number" required>
            </div>
            <div  class="row" >
            <div  class="left" >
                <label for="email">Email</label> 
            </div>
            <div  class="right" >
                <input type="text" name="email" placeholder="Email" required>
            </div>

            <br><br><br>
            <br><br><br>
        <div class="search">
            <input type="submit" value="Signup" class="register">
            <br><br>
        </div>
        </form>
    </div>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['Firstname']) && isset($_POST['LastName'])) {
        $Uname = $_POST['UserName'];
        $Lname = $_POST['LastName'];
        $Fname = $_POST['Firstname'];
        $Password = $_POST['Password'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $member = "admin";
        
    }
    $query = "INSERT INTO user (first_name,last_name,username,password,role,phone_number,email)
                   VALUES ('$Fname','$Lname','$Uname','$Password','$member','$phone','$email')";
        $result= mysqli_query($db_connection,$query);
        if ($result) {
            $id = mysqli_insert_id($db_connection);
            $message = "
            <div class='content'>
            <h4>Added content<h4>
            <br/>
            <div>";
            echo "$message";
        } else {
            mysqli_close($db_connection);
            $errors[] = "Error inserting Member: " . mysqli_error($db_connection);
        }
     
    }
    
    ?>
</body>
</html>