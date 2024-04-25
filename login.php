<?php
//login.php

include('database_connection.php');

if(isset($_SESSION['type']))
{
	header("location:index.php");
}

$message = '';
$v_msg = '';

if(isset($_POST["login"]))
{
    $email = $_POST["user_email"];


     // Validate email format
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<label>Invalid email address</label>";
    } else {
        $password = $_POST["user_password"]; // Plain text password from the form

        $query = "SELECT * FROM user_details 
            WHERE user_email = ?"; // Using a prepared statement to prevent SQL injection
            
        $statement = $connect->prepare($query);
        $statement->bind_param("s", $email); // Bind parameters
        $statement->execute();
        $result = $statement->get_result(); // Get the result set
        
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc(); // Fetch the first row
            if($row['user_status'] == 'Active')
            {
                if(password_verify($password, $row["user_password"])) // Compare hashed password
                {
                    // session_start();
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    header("Location:index.php");
                }
                else
                {
                    $message = "<label>Wrong Password</label>";
                }
            }
            else
            {
                $message = "<label>Your account is disabled, Contact Master</label>";
            }
        }
        else
        {
            $message = "<label>Wrong Email Address</label>";
        }
    }
}

    // if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    //     $v_msg =  "<label>Email address is VALID</label>";
    //     } else {
    // $v_msg = "<label>INVALID email</label>";
    // }

//     $password = $_POST["user_password"]; // Plain text password from the form

//     $query = "SELECT * FROM user_details 
//         WHERE user_email = ?"; // Using a prepared statement to prevent SQL injection
        
//     $statement = $connect->prepare($query);
//     $statement->bind_param("s", $email); // Bind parameters
//     $statement->execute();
//     $result = $statement->get_result(); // Get the result set
    
//     if($result->num_rows > 0)
//     {
//         $row = $result->fetch_assoc(); // Fetch the first row
//         if($row['user_status'] == 'Active')
//         {
//             if(password_verify($password, $row["user_password"])) // Compare hashed password
//             {
//                 // session_start();
//                 $_SESSION['type'] = $row['user_type'];
//                 $_SESSION['user_id'] = $row['user_id'];
//                 $_SESSION['user_name'] = $row['user_name'];
//                 header("Location:index.php");
//             }
//             else
//             {
//                 $message = "<label>Wrong Password</label>";
//             }
//         }
//         else
//         {
//             $message = "<label>Your account is disabled, Contact Master</label>";
//         }
//     }
//     else
//     {
//         $message = "<label>Wrong Email Address</label>";
//     }
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management System using PHP with Ajax Jquery</title>      
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <br />
    <div class="container">
        <h2 align="center">Inventory Management System using PHP with Ajax Jquery</h2>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form method="post">
                    <!-- <?php //echo $v_msg; ?><br> -->
                    <?php echo $message; ?><br>
                    <div class="form-group">
                        <label>User Email</label>
                        <input type="text" name="user_email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
