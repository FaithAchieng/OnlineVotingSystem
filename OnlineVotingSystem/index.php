<?php
require_once("./Admin/inc/config.php");
$fetchingElections=mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
while ($data=mysqli_fetch_assoc($fetchingElections)) {
	$starting_date=$data['starting_date'];
	$ending_date=$data['ending_date'];
	$curr_date=date("Y-m-d");
	$election_id=$data['id'];
	$status=$data['status'];
//Active=Expire=Ending date
//Inactive=Active=Starting date

if($status=="Active election"){
	$date1 = date_create($curr_date);
    $date2 = date_create($ending_date);
    if (!$date1 || !$date2) {
        echo "Error: Invalid date format";
        exit();
    }
 
    $diff = date_diff($date1, $date2);

	
    if ((int)$diff->format("%R%a days") < 0) {
       //update
	   mysqli_query($db,"UPDATE elections SET status='Expired' WHERE id='".$election_id."'") or die(mysqli_error($db));
    } 
}elseif($status=="Inactive election"){
	$date1 = date_create($curr_date);
    $date2 = date_create($starting_date);
    if (!$date1 || !$date2) {
        echo "Error: Invalid date format";
        exit();
    }
 
    $diff = date_diff($date1, $date2);

	
    if ((int)$diff->format("%R%a days") >= 0) {
       //update
	   mysqli_query($db,"UPDATE elections SET status='Active' WHERE id='".$election_id."'") or die(mysqli_error($db));
    
    } 
}
	

}


?>
<!DOCTYPE html>
<html>
    
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="Assets/css/login.css">
	<link rel="stylesheet" href="Assets/css/style.css">

</head>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="Assets/images/vote-box-11350_256.gif" class="brand_logo" alt="Logo">
					</div>
				</div>
           <?php
             if (isset($_GET['sign-up'])) {
				?>
                 <div class="d-flex justify-content-center form_container">
					<form method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="su_username" class="form-control input_user" value="" placeholder="username" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="text" name="su_contact_number" class="form-control input_pass" value="" placeholder="Contact no" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="su_password" class="form-control input_pass" value="" placeholder="Password" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="su_retype_password" class="form-control input_pass" value="" placeholder="Retype Password" required/>
						</div>
						
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						Already created an account? <a href="index.php" class="ml-2">Sign In</a>
					</div>
					
				</div>
				<?php
				
			 }else{
              ?>
               <div class="d-flex justify-content-center form_container">
					<form method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="contact_no" class="form-control input_user"  placeholder="Contact no"required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass"  placeholder="Password" required/>
						</div>
						
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="loginBtn" class="btn login_btn">Login</button>
				   </div>
					</form> 
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						Don't have an account? <a href="?sign-up=1" class="ml-2">Sign Up</a>
					</div>
					<div class="d-flex justify-content-center links">
						<a href="#" class="text-white">Forgot your password?</a>
					</div>
				</div>
			  <?php
			 }

		   ?>
       

	   <?php
	   if (isset($_GET['registered'])) {
		?>
  <span class="bg-white text-success text-center my-3"> You have Registered Successfully</span>
		<?php
	   }else if(isset($_GET['invalid'])){
		?>
<span class="bg-white text-danger text-center my-3">Password mismatched please try again</span>
		<?php
		 }else if(isset($_GET['not_registered'])){
			?>
	<span class="bg-white text-warning text-center my-3">You are not registered</span>
			<?php
			}else if(isset($_GET['invalid_access'])){
				?>
		<span class="bg-white text-danger text-center my-3">Invalid username or password</span>
				<?php
	   }

	   ?>

 
			</div>
		</div>
	</div>
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php
require_once("Admin/inc/config.php");
if (isset($_POST['sign_up_btn'])) {
	$su_username= mysqli_real_escape_string($db,$_POST['su_username']);
    $su_contact_number= mysqli_real_escape_string($db,$_POST['su_contact_number']);
    $su_password= mysqli_real_escape_string($db,sha1($_POST['su_password']));
    $su_retype_password= mysqli_real_escape_string($db,sha1($_POST['su_retype_password']));
	$user_role="Voter";

	if ($su_password == $su_retype_password) {
		//Insert QUERY

		mysqli_query($db,"INSERT INTO users(username,contact_no,password,user_role) VALUES('".$su_username."','".$su_contact_number."','".$su_password."','".$user_role."') ") or die(mysqli_error($db));
		?>

<script> location.assign("index.php?sign-up=1&registered=1");</script>
		<?php
	}else{
		?>
     <script> location.assign("index.php?sign-up=1&invalid=1");</script>
		<?php
	}

}elseif(isset($_POST['loginBtn'])){

	$contact_no= mysqli_real_escape_string($db,$_POST['contact_no']);
	$password= mysqli_real_escape_string($db,sha1($_POST['password']));
	  
	//	Query to fetch data
	$fetchingData=mysqli_query($db,"SELECT * FROM users WHERE contact_no='".$contact_no."'")or die(mysqli_error($db));
	

	if(mysqli_num_rows($fetchingData)>0){
		$data=mysqli_fetch_assoc($fetchingData);

		if($contact_no==$data['contact_no'] AND $password==$data['password']){
         session_start();
		 $_SESSION['user_role']=$data['user_role'];
		 $_SESSION['username']=$data['username'];
		 $_SESSION['user_id']=$data['id'];
	

		 if($data['user_role']== "Admin"){
			$_SESSION['key']="AdminKey";
			?>
         <script>location.assign("Admin/index.php?homepage=1");</script>
			<?php

		 }else{
			$_SESSION['key']="VotersKey";
			?>
			<script>location.assign("voters/index.php");</script>
			   <?php
		 }


		}else{
			?>
<script> location.assign("index.php?invalid_access=1");</script>
			<?php
		}
	}else{
		?>
          <script> location.assign("index.php?sign-up=1&not_registered=1");</script>
		<?php
	}
}
?>
