<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form  method="post" novalidate>
                
                <label for="child">Child Details</label> 
                <br><br>

                <label for="firstname">First Name</label> 
                 <input type="text" name="firstname"  placeholder="First Name" required>
                 <br>

                <label for="lastname">Last Name</label> 
                <input type="text" name="lastname" placeholder="Last Name"  required>
                <br>

                <label for="birthday">Date of Birth</label> 
                 <input type="date" name="DOB" required>
                 <br>

                <label for="gender">Gender</label> 
                <select name="gender"  >
                <!--select options-->
                <option value=""  >Select</option>
                <option value="male" >
                male</option>
                <option value="female" >
                female</option>
                </select>
                <br>

                <label for="category">category</label> 
                <select name="category"  >
                <!--select options-->
                <option value=""  >Select</option>
                <option value="babies" >
                babies</option>
                <option value="wobblers" >
                wobblers</option>
                <option value="toddelers" >
                toddlers</option>
                <option value="preschool" >
                Pre-School</option>
              </select>
              <br>

              <label for="duration">Duration</label> 
                <select name="duration"  >
                <!--select options-->
                <option value=""  >Select</option>
                <option value="1" >
                HALF DAY - €15.50</option>
                <option value="2" >
                FULL DAY - €20.00</option>
                <option value="3" >
                TWO DAYS - €55.00</option>
                <option value="4" >
                THREE DAYS - €75.50</option>
                <option value="5" >
                FIVE DAYS - €100.00</option>
                <option value="6" >
                WEEKEND - €150.00</option>
                </select>
                <br><br>
            <input type="submit" name="register" value="Register" class="register">

    </form>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['firstname']) || empty($_POST['firstname'])) {
            $errors[] = 'Please enter a valid First Name';
        }else{
            $fname = $_POST['firstname'];
        }
        if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
            $errors[] = 'Please enter a valid last Name';
        }else{
            $lname = $_POST['lastname'];
        }
        if (!isset($_POST['DOB']) || empty($_POST['DOB'])) {
            $errors[] = 'Please enter a valid birthday';
        }
        else{
            $dob = $_POST['DOB'];
        }
        if (!isset($_POST['gender']) || empty($_POST['gender'])) {
            $errors[] = 'Please select a gender';
        }
        else{
            $gender = $_POST['gender'];
        }
        if (!isset($_POST['category']) || empty($_POST['category'])) {
            $errors[] = 'Please select a valid category';
        }
        else{
            $category = $_POST['category'];
        }
        if (!isset($_POST['duration']) || empty($_POST['duration'])) {
            $errors[] = 'Please select a valid duration';
        }
        else{
            $duration = $_POST['duration'];
        }

        if (empty($errors)) {
        $query = "SELECT user_id FROM user WHERE username = '$Uname'";
        $result= mysqli_query($db_connection,$query);
        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            $userID= $data['user_id'];
        }


        $query = "INSERT INTO child (first_name,last_name,date_of_birth,gender,categories,user_id,fee_id)
            VALUES ('$fname','$lname','$dob','$gender','$category','$userID','$duration')";
            $result= mysqli_query($db_connection,$query);
            if ($result) {
                $id = mysqli_insert_id($db_connection);
                $message = "
                <div class='content'>
                <h4>Added content<h4>
                <br/>
                <div>";
                echo "$message";
            } 
            else {
                mysqli_close($db_connection);
                $errors[] = "Error inserting Member: " . mysqli_error($db_connection);
            }
        }
    ?>
</body>
</html>