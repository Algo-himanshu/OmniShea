<?php 
$link = mysqli_connect("localhost","root","", "phplogin");
$id = $_REQUEST['postid'];
$username = $_REQUEST['username'];
$querysave="SELECT * FROM save WHERE username='$username' AND postid='$id'";
$result = mysqli_query($link,$querysave);
if($result->num_rows === 0)
{
    
    $savequery="INSERT INTO save (username, postid) VALUES ('$username', '$id')";
}
else{
    $savequery="DELETE FROM save WHERE postid='$id' AND username='$username'";
}
mysqli_query($link,$savequery);
?>