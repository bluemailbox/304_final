<?php
session_start();
include "header.php";
?>
<!DOCTYPE html>
<html><link rel="stylesheet" href="mystyle.css">
<head>
<title>uploading image</title>
</head>
<body>
<h1>Image Uploading</h1> <h1><a href="index.php">Back to main menu</a></h1> 

<?php
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image 
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "<h2>Sorry, file already exists.<h2>";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "<h2>Sorry, your file is too large.<h2>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "<h2>Sorry, only JPG, JPEG, PNG & GIF files are allowed.<h2>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<h2>Sorry, your file was not uploaded.<h2>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    echo("<h2><a href=\"addprod.php\">Back to Add Products</a></h2>");
    echo("<h2><a href=\"editprods.php\">Back to Edit Products</a></h2>");
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>

</body>
</html>