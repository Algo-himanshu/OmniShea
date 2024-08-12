<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css?ts=<?=time()?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>OmniShea</h1>
				<a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
</body>
<body class="viewpost">
		<?php
		if(isset($_POST['submit-posttext']))
		{
            $link = mysqli_connect("localhost", "root", "", "phplogin");
            // Check connection
            if($link === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            // Escape user inputs for security
            $postuser = $_SESSION['name'];
            $posttitle = mysqli_real_escape_string($link, $_REQUEST['posttitle']);
            $postcontent = mysqli_real_escape_string($link, $_REQUEST['postcontent']);
			date_default_timezone_set('Asia/Kolkata');
			$postts=time();
			if ($title === '' || $content === '') {
				echo '<script>document.getElementById("failure").innerHTML = "<p>Title or post content not entered.</p>";</script>';
			} else {
	            //insert query execution
	            $sql = "INSERT INTO post(postuser,postcontent,posttitle,postts) VALUES ('$postuser', '$postcontent', '$posttitle', '$postts')";
	            if(mysqli_query($link, $sql)) {
	                echo "<script> alert('Post Submitted Succesfully'); window.location.assign('home.php'); </script>";
	            } else {
	                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	            }
			}
    	}
		if(isset($_POST['submit-postimage']))
		{
            $link = mysqli_connect("localhost", "root", "", "phplogin");
            // Check connection  
            if($link === false){
                 die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            // Escape user inputs for security
            $postuser = $_SESSION['name'];
            $posttitle = mysqli_real_escape_string($link, $_REQUEST['posttitle']);
            $postimage = mysqli_real_escape_string($link, $_REQUEST['postimage']);
			date_default_timezone_set('Asia/Kolkata');
			$postts=time();
			if ($posttitle === '' || $postimage === '') {
				echo '<script>document.getElementById("failure").innerHTML = "<p>Title or post content can not be empty.</p>";</script>';
			} else {
	            //insert query execution
	            $sql = "INSERT INTO post(postuser,postimage,posttitle,postts) VALUES ('$postuser','$postimage', '$posttitle', '$postts')";
	            if(mysqli_query($link, $sql)) {
	                echo "<script> alert('Post Submitted Succesfully'); window.location.assign('home.php'); </script>";
	            } else {
	                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	            }
			}
    	}
		if(isset($_POST['submit-postvideo']))
		{
            $link = mysqli_connect("localhost", "root", "", "phplogin");
            // Check connection  
            if($link === false){
                 die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            // Escape user inputs for security
            $postuser = $_SESSION['name'];
            $posttitle = mysqli_real_escape_string($link, $_REQUEST['posttitle']);
            $postvideo = mysqli_real_escape_string($link, $_REQUEST['postvideo']);
			date_default_timezone_set('Asia/Kolkata');
			$postts=time();
			if ($posttitle === '' || $postvideo === '') {
				echo '<script>document.getElementById("failure").innerHTML = "<p>Title or post content can not be empty.</p>";</script>';
			} else {
	            //insert query execution
	            $sql = "INSERT INTO post(postuser,postvideo,posttitle,postts) VALUES ('$postuser','$postvideo', '$posttitle', '$postts')";
	            if(mysqli_query($link, $sql)) {
	                echo "<script> alert('Post Submitted Succesfully'); window.location.assign('home.php'); </script>";
	            } else {
	                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	            }
			}
    	}

		echo 
		'<div class="split-pane">
		<div><br><br><br></div>
        	<h1>Create a new post</h1>
        	<form class="register-form" method="POST">
				<div class="content-type">
					<button type="submit" class="btnblue" id="sign-up-in-btn" value="Sign up" name="text-post">Text</button>
					<button type="submit" class="btnblue" id="sign-up-in-btn" value="Sign up" name="image-post">Image</button>
					<button type="submit" class="btnblue" id="sign-up-in-btn" value="Sign up" name="video-post">Video</button>
				';

	if(isset($_POST['text-post']))
	{
		echo '
		<div class=post-text>
		<form action="#" method="post">
          

		<div class="form-group">
    <label for="title"><span>TITLE</span></label>
    <input type="text" name="posttitle" id="title" class="form-controll"/>
  </div>
  <div class="form-group">
    <label for="caption">Caption <span></span></label>
    <input type="text" name="postcontent" id="textcontent" class="form-controll"/>
  </div>
  
  
  
  <div class="form-group">
    <button type="submit" name="submit-posttext">Upload</button>
  </div>
		</form>';
	}

	if(isset($_POST['image-post']))
	{
		echo '
		<div class=post-text>
		<form action="#" method="post">
           	
		
  
  <div class="form-group">
    <label for="title">Title <span>TEXT</span></label>
    <input type="text" name="posttitle" id="title" class="form-controll"/>
  </div>
  
  
  <div class="form-group file-area">
        <label for="images">Images <span>UPLOAD IMAGE</span></label>
    <input type="file" name="postimage" id="images" />
    <div class="file-dummy">
      <div class="success">Great, your files are selected. Keep on.</div>
      <div class="default">Please select some files</div>
    </div>
  </div>
  
  
  
  <div class="form-group">
    <button type="submit" name="submit-postimage">Upload</button>
  </div>
		</form>';
	}

	if(isset($_POST['video-post']))
	{
		echo '
		<div class=post-text>
		<form action="#" method="post">
           	<input id="posttitle" type="text" placeholder="title" name="posttitle"> <br> <br>
           	<input type="file" id="postvideo" name="postvideo" accept="video/mp4"> <br> <br>
         	<button type="submit" class="btnblue" id="sign-up-in-btn" value="Sign up" name="submit-postvideo">Submit Post</button></form>
			<div id="failure"></div>
		</div></div>
		</form>';
	}



















		?>
		<?php

    	// this will trigger when submit button click
    	
    	?>
    </div>
	</body>
</html>