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
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	</head>
	<body class="loggedin">
		<div class="ninja">
	 
		<nav class="navtop">
			<div>
				 


				<h1>OmniShea</h1>
				<a href="submit.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Create Post</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

		</div>
	 
		<div class="home">
	<div class="content-container">
		<?php
		
		function timeSince($times) {
			date_default_timezone_set('Asia/Kolkata');
			$time = time() - $times; // to get the time since that moment
			$time = ($time<1)? 1 : $time;
			// echo '<h1> '.time()." - ".$times." - ".$time. '</h1>';
			$tokens = array (31536000 => 'year', 2592000 => 'month', 604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second');//73446
			foreach ($tokens as $unit => $text) {
				if ($time < $unit) continue;
				$numberOfUnits = floor($time / $unit);
				return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
			}
		}
		


		$link = mysqli_connect("localhost", "root", "", "phplogin");
		$query = "SELECT postid, postuser, postcontent, postts, posttitle, upvotes,postscore, postimage ,downvotes,postvideo FROM post ORDER BY postid DESC";
		//ORDER BY log10(abs(upvotes-downvotes) + 1)*sign(upvotes-downvotes)+(unix_timestamp(postts)/300000) DESC";
		$result = mysqli_query($link, $query);
		if ($link === false) {
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		$name=$_SESSION['name'];
		//each post gets on Home page
		if(mysqli_query($link, $query)) {
			while ($row = mysqli_fetch_array($result))
			{
				$id = htmlspecialchars($row['postid'], ENT_QUOTES, 'UTF-8');
				$username = htmlspecialchars($row['postuser'], ENT_QUOTES, 'UTF-8');
				$title = htmlspecialchars($row['posttitle'], ENT_QUOTES, 'UTF-8');
				$content=htmlspecialchars($row['postcontent'], ENT_QUOTES, 'UTF-8');
				$score = htmlspecialchars($row['postscore'], ENT_QUOTES, 'UTF-8');
				$postts= htmlspecialchars($row['postts'], ENT_QUOTES, 'UTF-8');
				$postimage=htmlspecialchars($row['postimage'], ENT_QUOTES, 'UTF-8');
				$postvideo=htmlspecialchars($row['postvideo'], ENT_QUOTES, 'UTF-8');

		$querypic = "SELECT profilepic FROM accounts WHERE username='$username'";
		$row = mysqli_fetch_array(mysqli_query($link, $querypic));
		$profilepic= htmlspecialchars($row['profilepic'], ENT_QUOTES, 'UTF-8');


				echo '<div class="home2">';
				echo '<div class="row" id="post_' . $id  . '"' . '>
						<div class="score-container">

						<form method="POST" id= "votearrow"  ' . '">
							<input name="updoot" class="upvoteinput" type="image" id="updoot-'.  $id  . '" value="updoot" src="images/upvote.gif"/>
						</form>


						<br>

						<span class="score">' . $score . '</span>

						<form method="post" id="votearrow"  ' . '">
							<input name="downdoot" class="upvoteinput" type="image" id="downdoot-'. $id . '" value="downdoot" src="images/downvote.gif"/>
						</form>

						<br>

						</div>

						<div class="post-container">';
						
						echo '<p id="submission-info">
						
						 <img src='.$profilepic.' type=image/jpg   style="height:35px; border-radius: 50%; border:0.1px; width:10%">
						 <a href="?profile= '. $username . '">' .'&nbsp'. $username . '</a>
						 <small>'.' '.timeSince($postts). ' ago, </small><br>
						 <a href="viewpost.php?postid=' . $id . '"><b><font size="+1">'.$title.'</font></b></a></p>';

						// echo '<form action="" method="POST"><button type="submit" class="btnblue" id="sign-up-in-btn" value="Save" name="save">Video</button></form>"';

						//echo '<div class="title">'.$title.'</div><br></p>';
                     echo "<div class='postsx'>";
					if($content) {
                        echo  '<a href="viewpost.php?postid=' . $id . '">'.$content.'</a>'; 
                        echo '<br>';}
                    else if($postvideo) {
                            echo '<video width="720" height="450" controls><source src="'.$postvideo.'"  type="video/mp4"></video>';
                            echo '<br>';
                            }//width="320" height="240" //autoplay allows to play automatically
                    else if($postimage) {
                        echo '<a href="viewpost.php?postid=' . $id . '"><img src="'.$postimage.'" width="250" height="300"></a> ';
                        echo '<br>';
                    }  



					// $querysave="SELECT * from save WHERE postid='$id' AND username='$name'";
					// $result = mysqli_query($link, $querysave);
					echo "<input class='save' type ='image' id='$id' src='images/upvote.gif'>";
					// else echo "<i class='fas fa-bookmark save' id ='.$id.'></i>";   if($result->num_rows == 0) 




					echo '</div';
					echo '</div';
						
						
						
						
						
				echo "<div class='pimage'>";
				echo '<a href="viewpost.php?postid=' . $id  . '"> <i class="fa fa-comment" ></i></a> ';



				echo '</div></div></div>';
				echo '</div>';
			}
		}
		else
		{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
		
		?>
		<?php 
		if (isset($_SESSION['name'])) { echo "<input type='hidden' id='username' value='".$_SESSION['name']."'/>"; } ?>
	</div>
	<!-- <script>
		$(document).ready(function() {
			$('.like_btn').click(function() { //line 72 and 80....upvotee and downvote class
				var post_id_v=$(this).data('postId');
				var button=this;
				$(button).attr('disabled',true);
				$.ajax({
					url:'ajax.php?like',
					method:'post',
					datatype:'json',
					data:{post_id:post_id_v},
					success:function(response){
						if(response.status){
							console.log(response);
							$(button).attr('disabled',false);
							// $(button).data('userId',0);
							// $(button).html("<i class="fa fa-heart like_btn"></i>")
						}
						else{
							$(button).attr('disabled',false);
							alert('Something is wrong,try again after sometimes');
						}
					}
				})
			});
		});
		</script> -->

<script>
		$(document).ready(function() {
			$('.upvoteinput').click(function() { //line 72 and 80....upvotee and downvote class
				
				var id2 = $(this).attr('id');
				var id = id2.substr(id2.indexOf("-") + 1);
				var username = $('#username').val(); //session name

				if (username == null) {
					return false;
				}
				var votevalue = 0;
				if (id2.startsWith("updoot")) votevalue = 1;
				if (id2.startsWith("downdoot")) votevalue = -1;

				$.ajax({
					type: "POST",
					url: "vote.php?postid=" + id + "&username=" + username +"&vote=" + votevalue,
					data: "",
					success: function(msg){},
					error: function(msg){}
				});
				alert("Vote Done");
			});

			$('.save').click(function() { //line 72 and 80....upvotee and downvote class
				
				var id2 = $(this).attr('id');
				var id = id2.substr(id2.indexOf("-") + 1);
				var username = $('#username').val(); //session name
				

				if (username == null) {
					return false;
				}

				// var saved = 0;
				// if (id2.startsWith("save")) saved = 1;
				// if (id2.startsWith("unsave")) saved = -1;


				$.ajax({
					type: "POST",
					url: "save.php?postid=" + id + "&username=" + username,
					data: "",
					success: function(msg){},
					error: function(msg){}
				});
				alert(username);
				
			});
		});
		</script> 



		</div>
	</div>
	</body>
</html>





<!-- echo '
				<i class="bi bi-heart-fill unlike_btn text-danger" style="display:" data-post-id='.$id.'></i>
								<i class="bi bi-heart like_btn" style="display:" data-post-id='.$id.'></i>'; -->


<!-- 
								$savequery="Select * from save where username='$name' AND postid='$id'";
				$resultsave=mysqli_query($link,$savequery);

				if($resultsave->num_rows == 0)
				{
					echo '<form action="#" method="post"><button type="submit" name="save"><i class="far fa-bookmark"></i></button></form>';
					if(!isset($_POST['save'])) mysqli_query($link,"INSERT INTO save VALUES('','$id','$name')");
				}
				if($resultsave->num_rows > 0)
				{
					echo '<form action="#" method="post"><button type="submit" name="unsave"><i class="fas fa-bookmark"></i></button></form>';
					if(!isset($_POST['unsave'])) mysqli_query($link,"DELETE FROM save WHERE username='$name' AND postid='$id'");
				} -->


















				<!-- ajax 	// var id2 = $(this).attr('id');
				// var id = id2.substr(id2.sindexOf("-") + 1);
				// var username = $('#username').val();
				// if (username == null) {
				// 	return false;
				// }
				// // var votevalue = 0;
				// // if (id2.startsWith("updoot")) votevalue = 1;
				// // if (id2.startsWith("downdoot")) votevalue = -1;
				// $.ajax({
				// 	type: "POST",
				// 	url: "upvote.php?postid=" + id + "&username=" + username +"&vote=" + votevalue7g,
				// 	data: "",
				// 	success: function(msg){},
				// 	error: function(msg){}
				// }); -->


