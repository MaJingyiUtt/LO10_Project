<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//session_start();
require_once 'Objet_nounou.php';
//global $list_nounou;

foreach ($_POST["langues"] as $element) {
    //echo("<li>$element</li>");
    $list_langues[] = $element;
}
$langues = implode(":", $list_langues); //////////////////////////////
// echo $langues;
//////////////////////////////////////////////////////////////////////////////////////////////照片
$target_dir = "photos/";   //保存的位置         
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$photo = $_FILES["fileToUpload"]["name"];
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
/*
  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
  echo "File is an image - " . $check["mime"] . ".";
  $uploadOk = 1;
  } else {
  echo "File is not an image.";
  $uploadOk = 0;
  }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
  }
  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else { */
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
} else {
    //echo "Sorry, there was an error uploading your file.";
}
////////////////////////////
$get_list_nounou = $_COOKIE['list_nounou']; //取出list
$list_nounou = unserialize($get_list_nounou); ////unserialize list

$list_nounou[] = new nounou($_POST['login'], $_POST['mdp1'], $_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['ville'], $_POST['email'], $_POST['portable'], $langues, $_POST['experience'], $_POST['presentation'], "non", "non", $photo);
///////////////////////////
$ser_list_nounou = serialize($list_nounou); //serialize list
setcookie('list_nounou', $ser_list_nounou); //把serialize完的list存在cookie里面（不ser的话好像穿不过去）
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>merci</title>
        <link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="body.css">
        <link href="bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>
                    <a class="brand">Nounou</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="home.html">Home</a><p/>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
                <div class="hero-unit">
                    <center><h3>Merci pour votre candidature, elle serai valider par l'administrateur</h3></center>
                </div></div>

        <?php
        /* echo("<pre>");
          print_r($list_nounou);
          print_r($_COOKIE);
          echo("</pre>"); */
//echo "<img src= photos/".$_FILES["fileToUpload"]["name"]." width='100' alt='photo'/>";
        ?>
    </body>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
    </script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script>
        !function ($) {
            $(function () {
                // carousel demo
                $('#myCarousel1').carousel()
            })
        }(window.jQuery)
    </script>
</html>
