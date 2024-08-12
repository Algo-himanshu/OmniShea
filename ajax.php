<?php
session_start();
if (!isset($_SESSION['loggedin'])){
    header('Location: index.html');
    exit;}
    
    $link = mysqli_connect("localhost", "root", "", "phplogin");







if(isset($_GET['like'])){
    $post_id = $_POST['post_id'];
    

    
    
        echo json_encode($_POST);
    }

?>

<!-- if(!checkLikeStatus($post_id)){
        if(like($post_id)){
            $response['status']=true;
        }else{
            $response['status']=false;
        } -->