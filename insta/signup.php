<?php 
// Start session
session_start();

include('connection.php');

//If username exists in the users table print error

$queryerror = " Error running the query! ";
$usererror  = " That username is already registered. You might want to log in. ";
$emailerror = " That email is already registered. You might want to log in. ";
$confirm    = " Passwords don\'t match. ";
$success    = " Successfully registered !";

$_SESSION['signuperrors'] = "";

$username = $_POST["username"];
$email    = $_POST["email"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

//If both passwords don't match print error
if($password != $cpassword){
    $_SESSION['signuperrors'] .= $confirm;
    header("Location: index2.php");
    exit();
}

//If username exists in the users table print error
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);

if(!$result){
    $_SESSION['signuperrors'] .= $queryerror;
    header("Location: index2.php");
    exit();
}

$results = mysqli_num_rows($result);

if($results){
    $_SESSION['signuperrors'] .= $usererror;
    header("Location: index2.php");
    exit();
}

//If email exists in the users table print error
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);

if(!$result){
    $_SESSION['signuperrors'] .= $queryerror;
    header("Location: index2.php");
    exit();
}

$results = mysqli_num_rows($result);

if($results){
    $_SESSION['signuperrors'] .= $emailerror;
    header("Location: index2.php");
    exit();
}

if(empty($_SESSION['signuperrors'])){
    
    //No errors. Create an entry in users table
    $sql = "INSERT INTO users (username, email, password)
    VALUES ('$username', '$email', '$password')";

    if ($link->query($sql) === TRUE) {
        $_SESSION['signuperrors'] = $success;
        echo "<script>alert('$success');</script>";
    }

    else {
        $_SESSION['signuperrors'] .= $queryerror;
        header("Location: index2.php");
        exit();
    }
}

$link->close();
header("Location: index2.php");
?>