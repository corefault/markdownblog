<?php

$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/";
date_default_timezone_set("Europe/Berlin");
$now = date("Y-m-d_His");

if (isset($_GET["image"])) {
   $imagename = "";
   // handle the file
   if ($_FILES["file"]["error"] == 0) {
      $imagename = "/posts/images/{$now}";
      move_uploaded_file($_FILES["file"]["tmp_name"], "{$ROOT}$imagename");
      
      echo "<script type='text/javascript'>window.top.window.stopUpload('![alt]($imagename)');</script>";
   }
   
} else if (isset($_GET["create"])) {
   // write mdown file
   $content = $_POST["md"];
   file_put_contents("{$ROOT}posts/{$now}.md", $content);

   // redirect to home
   header("Location: index.php");
} 
?>
