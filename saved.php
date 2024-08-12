<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: index.html');
  exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$link = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$name=$_SESSION['name'];
if (mysqli_connect_errno()) {
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$query="SELECT * from accounts WHERE username='$name'";
$row = mysqli_fetch_array(mysqli_query($link, $query));
$email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
$bio = htmlspecialchars($row['bio'], ENT_QUOTES, 'UTF-8');
$profilepic= htmlspecialchars($row['profilepic'], ENT_QUOTES, 'UTF-8');

// $stmt = $con->prepare('SELECT password, email ,bio FROM accounts WHERE id = ?');
// $stmt->bind_param('i', $_SESSION['id']);
// $stmt->execute();
// $stmt->bind_result($password, $email);
// $stmt->fetch();
// $stmt->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  </head>
  <body class="loggedin">
    <nav class="navtop">
      <div>
        <h1>OmniShea</h1>
        <a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        <a href="submit.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Create Post</a>
        <a href="product.php"><i class="fa-regular fa-address-card"></i>About</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
      </div>
    </nav>
    <?php echo'
    <div class="content">
      <div class="imgbox">
        <img src="'.$profilepic.'"></image>
      </div>
      <div class="userdetails">
        <table>
          <tr>
            <td><h2>'.$_SESSION['name'].'</h2></td>
          </tr>
          <tr>
            <td><h2>'.$email.'</h2></td>
          </tr>
          <tr>
            <td><br></td>
          </tr>
          <tr>
            <td><h2>'.$bio.'</h2></td>
          </tr>
          <tr>
            <td><a href="updateprofile.php"><button class="button" type="submit" name="submit">Update Profile</button></a></td>
          </tr>
          <tr>
            <td><a href="saved.php"><button class="button" type="submit" name="submit">Saved Post</button></a></td>
          </tr>
        </table>
      </div>
    </div>
';?>

<div class="home">
      <div class="profile-content">
        <h1>Saved Post</h1>
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
$name  = $_SESSION['name'] ;
$link = mysqli_connect("localhost", "root", "", "phplogin");
// $query = "SELECT postid, postuser, postcontent, postts, posttitle, upvotes,postscore, postimage ,downvotes FROM post WHERE postuser = '$name' ORDER BY postid DESC";
$query = "SELECT * FROM save WHERE username = '$name' ORDER BY postid DESC";
//ORDER BY log10(abs(upvotes-downvotes) + 1)*sign(upvotes-downvotes)+(unix_timestamp(postts)/300000) DESC"; 
$result = mysqli_query($link, $query);
if ($link === false) {
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
//each post gets on Home page
if(mysqli_query($link, $query)) {
  while ($row = mysqli_fetch_array($result))
  {
    $savedid=htmlspecialchars($row['postid'], ENT_QUOTES, 'UTF-8');

    $row2= mysqli_fetch_array(mysqli_query($link,"SELECT * FROM post WHERE postid = '$savedid' "));

    $id = htmlspecialchars($row2['postid'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($row2['postuser'], ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($row2['posttitle'], ENT_QUOTES, 'UTF-8');
    $content=htmlspecialchars($row2['postcontent'], ENT_QUOTES, 'UTF-8');
    $score = htmlspecialchars($row2['postscore'], ENT_QUOTES, 'UTF-8');
    $postts= htmlspecialchars($row2['postts'], ENT_QUOTES, 'UTF-8');
    $postimage=htmlspecialchars($row2['postimage'], ENT_QUOTES, 'UTF-8');
    $postvideo=htmlspecialchars($row2['postvideo'], ENT_QUOTES, 'UTF-8');
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
                        echo '<video width="720" height="450" controls ><source src="'.$postvideo.'"  type="video/mp4"></video>';
                        echo '<br>';
                        }//width="320" height="240" //autoplay allows to play automatically
                else if($postimage) {
                    echo '<a href="viewpost.php?postid=' . $id . '"><img src="'.$postimage.'" width="250" height="300"></a> ';
                    echo '<br>';
                }  
        
        
        
        
        
          echo "<div class='pimage'>";
    echo '<a href="viewpost.php?postid=' . $id  . '"> <i class="fa fa-comment" ></i> Add a Comment </a> </p></div></div>';
    echo '</div>';
    echo '</div>';
  }
}
else
{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

?>
<?php if (isset($_SESSION['name'])) { echo "<input type='hidden' id='username' value='".$_SESSION['name']."'/>"; }?>
</div>
<script>
$(document).ready(
  function()
  {
    $('.upvoteinput').click(function() //$(this) is used to point at super element variable
    {
      var id2 = $(this).attr('id');//line 64 
      var id = id2.substr(id2.indexOf("-") + 1);//basically id will have id of the post
      var username = $('#username').val(); //session name
      if (username == null) {
        return false;
      }
      var votevalue = 0;
      if (id2.startsWith("updoot")) votevalue = 1;
      if (id2.startsWith("downdoot")) votevalue = -1;
      $.ajax({
        type: "POST",
        url: "vote.php?postid=" + id + "username=" + username +"vote=" + votevalue,
        data: "",
        success: function(msg){},
        error: function(msg){}
      });
    });
});
</script>
</div>
</div>
</body>
</html>