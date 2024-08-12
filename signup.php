<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con= mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$name=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email'];
$query = "INSERT INTO accounts(username,password,email) VALUES('$name','$password','$email')";
if(isset($_POST['SignUp']))
{
    if(mysqli_query($con,$query)) { echo "<script> alert('Registered Succesfully'); </script>"; header('Location: index.html'); }
    else echo "error";
}
?>



<!-- 
if($_SERVER['REQUEST_METHOD'=="POST"])
{
    $a=$_POST['num'];
    $b=$_POST['den'];
class DivisionByNegative extends Exception{
function errorMessage(){
return this-> getMessage();
}
} 
class DivisionByZeroNumber extends Exception{
function errorMessage(){
return this-> getMessage();
}
} 
class DivisionByGreater extends Exception{
function errorMessage(){
return this-> getMessage();
}
} 

try{
    if($a<0)
    throw new DivisionByNegative("Provide A Valid Denominator");
}
catch(DivisionByNegative $en){
    echo $en-> getMessage();
}
try{
    if($a==0)
    throw new DivisionByZero("Provide A Valid Denominator");
}
catch(DivisionByZero $en){
    echo $en-> getMessage();
}
try{
    if($b>$a)
    throw new DivisionByNegative("Provide A Valid Denominator");
}
catch(DivisionByGreater $en){
    echo $en-> getMessage();
}

}

getfile();
getline(); -->