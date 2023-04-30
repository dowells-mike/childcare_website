<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration edit</title>
</head>
<body>
    <h1>FEE INFORMATION</h1>
    <table width="100%" border=1px solid black style="border-collapse:collapse;">
    <thead>
    <tr>
    <th><strong>FEE ID</strong></th>
    <th><strong>DURATION</strong></th>
    <th><strong>FEE</strong></th>
    </tr>
    </thead>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require ('/Applications/XAMPP/connectiontest.php');
    $count=1;
    $query = "SELECT * FROM FEE ORDER BY fee_id";
    $result= mysqli_query($db_connection,$query);
    while($row = mysqli_fetch_assoc($result)) {
        ?>
    <tr><td align="center"><?php echo $count; ?></td>
    <td align="center"><?php echo $row["fee"]; ?></td>
    <td align="center"><?php echo $row["duration"]; ?></td>
    </tr>
    <?php $count++; } ?>
    </tbody>
    </table>
    <h1>EDIT INFORMATION</h1>
    <form action="" method="post">
        <Label>SELECT FEE ID TO EDIT</Label>
        <select name="fee_id" id="fee_id">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        </select>
        <input type="submit" name="edit" value="edit">
    </form>
    <?php
    if (isset($_POST['edit'])) {
        $fee_id=$_POST['fee_id'];
        $sql = "SELECT * FROM fee WHERE fee_id = '$fee_id'";
        $result = mysqli_query($db_connection, $sql);
        $data = mysqli_fetch_assoc($result);
        if ($data) {
    ?>
    <h3>FOR SELECTED FEE ID THIS IS THE DATA BELOW</h3>
    <form action="" method="post">
    <label for="fee_id">FEE ID</label> 
    <input type="number" name="fee_id" value= "<?php echo $data['fee_id'];?>"  readonly>
    <label for="fee">FEE</label> 
    <input type="number" name="fee" value= "<?php echo $data['fee'];?>"  required>
    <br><br>
    <label for="duration">DURATION</label> 
    <input type="text" name="duration" value= "<?php echo $data['duration'];?>"  required>
    <br><br>
    <input type="submit" name="update" value="update table">

    </form>
    <?php
        } else {
            echo "incorrect ID";
        }
    }
    if (isset($_POST['update'])) {
        $fee_id=$_POST['fee_id'];
        $fee=$_POST['fee'];
        $duration=$_POST['duration'];
        $sql = "UPDATE fee SET fee = '$fee', duration = '$duration' WHERE fee_id = '$fee_id'";

        if (mysqli_query($db_connection, $sql)) {
            header("location: registration_edit.php");
            exit;
        }
        else{
            echo "error changing data";
        }
    }

    ?>
    

</body>
</html>