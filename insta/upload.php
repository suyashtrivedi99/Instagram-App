<?php
  //Start session
  session_start();

  include('connection.php');

  $queryerror = " Error running the query! ";

  $username = $_SESSION['username'];
  $message = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {

    $sql = "SELECT id FROM images ORDER BY id DESC LIMIT 1";

    // execute query
    $curid = 0;

    if($result = mysqli_query($link, $sql)) {
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $curid = $row['id'];
    }}}

    $curid += 1;

  	// Get image name
  	$image = "IMG00" . $curid;

    // Get text
  	$image_text = mysqli_real_escape_string($link, $_POST['image_text']);

  	// image file directory
  	$target = "images/$image.jpg";

  	$sql = "INSERT INTO images (image, hash, username) VALUES ('$image', '$image_text', '$username')";
  	
    // execute query
  	mysqli_query($link, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$message = "Image uploaded successfully";
  	}
    else {
  		$message = "Failed to upload image";
  	}
  }

  if($message != "")
    echo "<script>alert('" . $message . "');</script>";

  $link->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload</title>

  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<style type="text/css">
    html,body { 
      height: 100%; 
        margin: 0px; 
        padding: 0px; 
    } 

   .full {
        height: 100% 
    }

    .white-color {
        background-color: #b8c6db;
        background-image: linear-gradient(315deg, #b8c6db 0%, #f5f7fa 74%);
    }

    .bor-l{
        border-left-style: solid;
        border-color: lightblue;
    }

    .bor-r{
        border-right-style: solid;
        border-color: lightblue;
    }

    img {
      max-width:90%;
      height:auto;
    }

</style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Picstagram</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Upload <span class="sr-only">(current)</span></a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="mainpageloggedin.php">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <!--<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>-->
      </ul>
      <ul class="navbar-nav navbar-right">
            <li class="nav-item active"><a class="nav-link" href="#">Logged in as <b><?php echo $username ?></b></a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
      <!--<form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
      </form>-->
    </div>
  </nav>

  <div class="row full">
    <div class="col-md-4 white-color bor-r"></div>
    <div class="col-md-4">
      <center><h6 style="margin-top: 5%"><u>Upload an image</u></h6>
      
      <img id="curimage">
         
      <form method="POST" action="upload.php" enctype="multipart/form-data" style="margin-top: 5%">
        <div>
          <input type="file" name="image" id="inputimg" onchange="disp(event)" class="btn btn-primary">
        </div>
        <div>
          <textarea 
            style="margin: 5%" 
            id="text" 
            cols="40" 
            rows="4" 
            name="image_text" 
            placeholder="Type something for caption..."></textarea>
        </div>
        <div>
          <button type="submit" name="upload" class="btn btn-danger">Post</button>
        </div>
      </form>
      </center>
    </div>
    <div class="col-md-4 white-color bor-l"></div>
  </div>

  

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
      function disp(event){
        var cur = document.getElementById('curimage');
        cur.src = URL.createObjectURL(event.target.files[0]);
      };

    </script>

</body>
</html>