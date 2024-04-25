<?php

//edit_profile.php

include('database_connection.php');

if(isset($_POST['user_name']))
{
	$oldPassword = $_POST["user_old_password"];

	$userId = $_SESSION['user_id'];
    $query = "SELECT user_password FROM user_details WHERE user_id = ?"; 
    $statement = $connect->prepare($query);
    $statement->bind_param("i", $userId);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if(!password_verify($oldPassword, $row['user_password'])) {
        echo "<label class='text-danger'>Old password is incorrect.</label>";
        exit();
    } elseif ($_POST["user_new_password"] != '')
	{
		$query = "UPDATE user_details SET 
			user_name = '".$_POST["user_name"]."', 
			user_email = '".$_POST["user_email"]."', 
			user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
			WHERE user_id = '".$_SESSION["user_id"]."'
		";
	}
	else
	{
		$query = "UPDATE user_details SET 
			user_name = '".$_POST["user_name"]."', 
			user_email = '".$_POST["user_email"]."'
			WHERE user_id = '".$_SESSION["user_id"]."'
		";
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->get_result();
	if(isset($result))
	{
		echo '<div class="alert alert-success">Profile Edited</div>';
	}
}

// if(isset($_POST['user_name']))
// {
// 	if($_POST["user_new_password"] != '')
// 	{
// 		$query = "UPDATE user_details SET 
// 			user_name = '".$_POST["user_name"]."', 
// 			user_email = '".$_POST["user_email"]."', 
// 			user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
// 			WHERE user_id = '".$_SESSION["user_id"]."'
// 		";
// 	}
// 	else
// 	{
// 		$query = "UPDATE user_details SET 
// 			user_name = '".$_POST["user_name"]."', 
// 			user_email = '".$_POST["user_email"]."'
// 			WHERE user_id = '".$_SESSION["user_id"]."'
// 		";
// 	}
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->get_result();
// 	if(isset($result))
// 	{
// 		echo '<div class="alert alert-success">Profile Edited</div>';
// 	}
// }

?>