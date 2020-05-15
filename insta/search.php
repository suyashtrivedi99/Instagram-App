<?php
	//Start session
  	session_start();

  	include('connection.php');

  	$files = scandir("images");
  	$q = $_REQUEST["q"];

	//run a query to look for images
	$sql = "SELECT * FROM images ORDER BY id DESC";

	//shows notes or alert message
	if($result = mysqli_query($link, $sql)) {
	    if(mysqli_num_rows($result) > 0) {
	        
	        while($row = mysqli_fetch_array($result)) {
	            $image = $row['image'];
	            $caption = $row['hash'];
	            $username = $row['username'];

	            //Splitting string into array
	            $array = str_split($q);
	            $flag = 0;

	            //Hashtag Search
	            if($array[0] == '#')
	            {
	            	if (!empty($q) && strpos($caption, $q) !== false) {
	            		$flag = 1;
	            	}
	            }

	            //Username Search
	            else
	            {
	            	if (!empty($q) && strpos($username, $q) !== false) {
	            		$flag = 1;
	            	}
	            }
	            
	            //echo $array[0];

	            if ($flag === 1)
	            echo    "<div class='row' style='margin: 2%; margin-bottom: 10%; border-style: solid; border-color: grey; border-size: 1px'>
	            			<div>
	            				<img src='img/user.jpg' style='height: 50px; width: 50px'>
	                        	<b>$username</b>
	                        	<a download='$image.jpg' href='images/$image.jpg' class='btn btn-success ml-5'>Download</a>
	                        </div>

	                        <div>
	                        	<center><img src='images/$image.jpg'></center>
	                        </div>
	                        <div style='margin: 5%'>
	                        	<u>Caption</u>: $caption
	                        </div>
	                        
	                    </div>";
	        }
	    }

	    else {
	        echo '<div class="alert alert-warning">No images available!</div>';
	        exit;
	    }
	    
	}

	else {
	    echo '<div class="alert alert-warning">An error occured!</div>'; exit;
	}
?>
