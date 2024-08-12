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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="style5.css">
</head>
<body>
	<div class="Recents">
		<h2>Recent Posts</h2>


	</div>	
	<div class="card">
		<div class="imgbox">
			<img src="omni2.png"></image>
		</div>
		<div class="content">
			<div class="details">
  			<h2><?=$_SESSION['name']?></h2>
  			<div class="data">
  				<h3><span>Posts<br></span></h3>
  			</div>
			</div>
		</div>
	</div>
</body>
</html>