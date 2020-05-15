<?php 
// Start session
session_start();

include('connection.php');

$loginerror = "Invalid username or password!";
$queryerror = " Error running the query! ";

$_SESSION['loginerrors'] = "";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
$result = mysqli_query($link, $sql);

if(!$result){
    $_SESSION['loginerrors'] .= $queryerror;
    header("Location: index.php");
    exit();
}

$results = mysqli_num_rows($result);

if($results == 0){
	$_SESSION['loginerrors'] .= $loginerror;
	header("Location: index.php");
    exit();
}

else{
	$row = mysqli_fetch_assoc($result);
    
    $_SESSION['username'] = $row["username"];
    $_SESSION['email'] = $row["email"];
    
    mysqli_free_result($result);
}

$link->close();
header("Location: mainpageloggedin.php");
?>