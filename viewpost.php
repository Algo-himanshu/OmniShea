<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit;
    }
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'phplogin';
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error());
    } 
    echo "Connected successfully";
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Viewpost</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>


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
?>


    <body>
		<nav class="navtop">
			<div>
				<h1>OmniShea</h1>
                <a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
				<a href="submit.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create Post</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
        <div><br><br><br></div>
        <div class="home">
            <div class="content-container">

        <?php
		$link = mysqli_connect("localhost", "root", "", "phplogin");
        $postid = $_REQUEST['postid'];
        $postid = mysqli_real_escape_string($link, $postid);
		$query = "SELECT * FROM post WHERE postid=$postid";
		$result = mysqli_query($link, $query);
		if ($link === false) {
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
        if(mysqli_query($link, $query))
        {
    		while($row = mysqli_fetch_array($result))
            {
            $id = htmlspecialchars($row['postid'], ENT_QUOTES, 'UTF-8');
			$username = htmlspecialchars($row['postuser'], ENT_QUOTES, 'UTF-8');
			$title = htmlspecialchars($row['posttitle'], ENT_QUOTES, 'UTF-8');
			$content=htmlspecialchars($row['postcontent'], ENT_QUOTES, 'UTF-8');
			$score = htmlspecialchars($row['postscore'], ENT_QUOTES, 'UTF-8');
			$postts= htmlspecialchars($row['postts'], ENT_QUOTES, 'UTF-8');
			$postimage=htmlspecialchars($row['postimage'], ENT_QUOTES, 'UTF-8');
            $postvideo=htmlspecialchars($row['postvideo'], ENT_QUOTES, 'UTF-8');
			echo '<div class="home2">';
			echo '<div class="row" id="post_' . $id  . '"' . '>
					<div class="score-container">

					<form method="POST" id= "votearrow"  ' . '">
						<input name="updoot" class="upvoteinput" type="image" id="updoot-'.  $id  . '" value="updoot" src="images/upvote.gif"/>
					</form>

					<span class="score">' . $score . '</span>

					<form method="post" id="votearrow"  ' . '">
						<input name="downdoot" class="upvoteinput" type="image" id="downdoot-'. $id . '" value="downdoot" src="images/downvote.gif"/>
					</form>

					</div>

					<div class="post-container">';

					echo '<p id="submission-info">	
					<i class="fa fa-user"></i><a href="?profile= '. $username . '">' .' '. $username . '</a> ';	
					echo timeSince($postts). ' ago, ';			
					echo '<br>';
		
					echo $title .'<br>';
					if($content) {
                        echo  $content ;
                        echo '<br>';}
                    else if($postvideo) {
                            echo '<video width="720" height="450" controls autoplay><source src="'.$postvideo.'"  type="video/mp4"></video>';
                            echo '<br>';
                            }//width="320" height="240" //autoplay allows to play automatically
                    else if($postimage) {
                        echo '<a href="viewpost.php?postid=' . $id . '"><img src="'.$postimage.'" width="250" height="300"></a> ';
                        echo '<br>';
                        }
                    
    		}

        }
        else echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
        ?>

        <!--------------------------------------------------POSTING NEW COMMENTS------------------------------------------------------------------->

        <?php
        echo "<br><br><br><br>";
        echo '<div class="post-comment"><form id="comment-form" method="POST"><textarea id="comment-content" type="text" placeholder="Write Your Comment" name="comment" rows="5" cols="150"></textarea>
                <button type="submit" class="btnblue" id="sign-up-in-btn"  name="post-comment"> Post comment </button></form></div><div id="failure"></div>';
    	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['post-comment'])){
            $link = mysqli_connect("localhost", "root", "", "phplogin");
            // Check connection
            if($link === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            // Escape user inputs for security
            $commentuser = $_SESSION['name'];
            $postid = $_REQUEST['postid'];
            date_default_timezone_set('Asia/Kolkata');
			$commentts=time();
            $comment = mysqli_real_escape_string($link, $_REQUEST['comment']);

            // attempt insert query execution
            if ($comment === '') {
				echo "<script>document.getElementById('failure').innerHTML = '<p>You didn't write anything in comment field.</p>';</script>";
			} else {
                $sql = "INSERT INTO comment (commentuser, postid, comment,commentts) VALUES ('$commentuser', '$postid', '$comment','$commentts')";
                if(mysqli_query($link, $sql)) {
                    // echo "Records added successfully.";
                    $msg = 'Comment submitted successfully!';
                    header('Refresh: 0');
                    alert("$msg");
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
            }
    	}
        ?>

        <!-----------------------------------------------------PRINTING ALL COMMENTS-------------------------------------------------------------->
        
        <?php
        
        echo "<br><br><br><br>";
		$link = mysqli_connect("localhost", "root", "", "phplogin");
        $postid = mysqli_real_escape_string($link, $_REQUEST['postid']);
		$query = "SELECT * FROM comment WHERE postid=$postid ORDER BY commentid DESC";
        
		$result = mysqli_query($link, $query);
		if ($link === false) {
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
        if(mysqli_query($link, $query)) {

            if ($result->num_rows == 0) {
                echo "<div class='empty-comments'><p>There doesn't seem to be anything here yet</p></div>";
            }
            else {
                echo '<div class="home2">';
        		while($row = mysqli_fetch_array($result))
                {
                    $postid = htmlspecialchars($row['postid'], ENT_QUOTES, 'UTF-8');
                    $commentuser = htmlspecialchars($row['commentuser'], ENT_QUOTES, 'UTF-8');
                    $comment = htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8');
                    $commentts = htmlspecialchars($row['commentts'], ENT_QUOTES, 'UTF-8');

                    echo '<div class="comment-container">';
						
						echo '<p id="submission-info">
						
						<i class="fa fa-user"></i><a href="?profile= '. $username . '">' .' '. $commentuser . '</a> ';
						
						echo timeSince($commentts). ' ago, ';
						
						echo '<br>';
						 
							echo '<p>'. $comment .'</p>';
							echo '<br>';
						
        		}
            }
        } else {
			echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
		}


        ?>

    </div>
    </div>
</body>
</html>
