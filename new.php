<?php
$link = mysqli_connect("localhost","root","", "phplogin");
$id = $_REQUEST['postid'];
$username = $_REQUEST['username'];
$points = $_REQUEST['vote'];


//fetching score,upvotes downvotes
$queryscore = "SELECT * FROM post WHERE postid='$id' ";
$resultscore = mysqli_query($link, $queryscore);
$rowscore = mysqli_fetch_array($resultscore);
$score=$rowscore['postscore'];
$upvotes=$rowscore['upvotes'];
$downvotes=$rowscore['downvotes'];
$totalpoints=$score+$points;
$totalpoint=$totalpoints-1;

if (!($points >= -1 && $points <= 1)) {
    $points = 0;
}



$vote = "INSERT INTO vote (username, postid, score) VALUES ('$username', '$id', $points)";

$check = "SELECT * FROM vote WHERE postid='$id' AND username='$username'";
$result = mysqli_query($link, $check);
$row = mysqli_fetch_array($result);



// checks if user has already voted
if($result->num_rows == 0) {
    // not yet voted, will vote for first time
    mysqli_query($link, $vote);
    if ($points == 1) {
        $update = "UPDATE post SET postscore='$totalpoints' WHERE postid='$id'";
    }
    mysqli_query($link, $update);
}

elseif ($result->num_rows > 0)
{
    $deletevote="DELETE FROM vote WHERE postid='$id' AND username='$username'";
    $update="UPDATE post SET postscore='$totalpoint' WHERE postid='$id'";
    mysqli_query($link, $deletevote);
    mysqli_query($link, $update);

    
} 
else
{
    echo "ERROR: Could not able to execute" . mysqli_error($link);
}
?>

<!-- // // validates voting points value
// if (!($points >= -1 && $points <= 1)) {
//     $points = 0;
// }
// if ($link === false) {
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }
// $vote = "INSERT INTO vote (username, postid, score) VALUES ('$username', '$id', $points)";
// $check = "SELECT * FROM vote
//                     WHERE postid='$id' AND postuser='$username'";

// // finds row where given user has voted for given post

// $result = mysqli_query($link, $check);
// $row = mysqli_fetch_array($result);

// // checks if user has already voted
// if($result->num_rows === 0) {
//     // not yet voted, will vote for first time
//     // echo "New vote";
//     mysqli_query($link, $vote);
//     if ($points == 1) {
//         $updatenews = "UPDATE post SET score=$points, upvotes=upvotes+1 WHERE postid='$id'";
//     } elseif ($points == -1) {
//         $updatenews = "UPDATE post SET score=$points, downvotes=downvotes-1 WHERE postid='$id'";
//     }
//     mysqli_query($link, $updatenews); -->






<!-- $deletevote="DELETE FROM vote WHERE postid='$id' AND username='$username'";
    $update="UPDATE post SET postscore='$totalpoints', upvotes='$upvotes+1' WHERE postid='$id'""
    

} -->