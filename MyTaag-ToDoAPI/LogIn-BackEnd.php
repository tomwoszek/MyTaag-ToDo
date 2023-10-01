<?php
// Sicherstellung der Startung der Sitzung
session_start();

include("connection.php");
include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		 
		$user_email = $_POST['user_email'];
		$password = $_POST['password'];
         
 
		if(!empty($user_email) && !empty($password) && !is_numeric($user_email))
		{

 
			$query = "select * from users where user_email = '$user_email' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
                    
					$user_data = mysqli_fetch_assoc($result);

					
					if($user_data['password'] === $password)
					{
                        
						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: Todos-FrontEnd.php");
						die;
					}
				}
			}
			
			echo "Falsches Password oder falsche MyTaag-ID!";
		}else
		{
			echo "Falsches Password oder falsche MyTaag-ID!";
		}
	}

?>