<?php
   session_start();
   
   // what kind of theme do you want ?
   $_theme = "theme/minimal/";
   
   require_once("libs/Parsedown.php");
   require_once("libs/posts.php");
   
   if (isset($_GET["q"])) {
      $_SESSION["id"]++;
      include "{$_theme}content.php";
   } else {
      // startup or single post
      session_destroy();
      
      if (isset($_GET["post"])) {
         $_SESSION["id"] = "!" . $_GET["post"];
      } else {
         $_SESSION["id"] = 0;
      }
      
      include "{$_theme}/header.php";
      include "{$_theme}/content.php";
      include "{$_theme}/footer.php";
   } 
   unset($p);
?>
   