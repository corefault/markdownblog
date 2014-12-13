<?php

class posts {

   var $list = array();

   /**
    * constructor reads all files from posts folder
    * and store the information in internal list.
    */
   function posts() {
      $ROOT = $_SERVER['DOCUMENT_ROOT']."/";
      if ($handle = opendir("{$ROOT}posts")) {
         while (false !== ($file = readdir($handle))) {
            if (preg_match("/md$/", $file)) {
               $this->list[] = $file;
            }
         }
         closedir($handle);
      }
      rsort($this->list);
   }
   
   /**
    * Size of array.
    * @return number of posts.
    */
   function size() {
      return count($this->list);
   }

   /**
    * Read ad translate a post from amrkdown into html.
    * @param type $index the index from list.
    * @return type html markup
    */
   function getAtIndex($index) {
      return $this->getPost($this->list[$index]);
   }
   
   /**
    * Get converted date of published file.
    * @param type $index the index from list
    * @return type converted date
    */
   function getDate($index) {
      $da = $this->getPermaLink($index);
      return strtotime($da);
   }
   
   /**
    * Get only the filename.
    * @param type $index the index of file in list.
    * @return type basefilename without extension
    */
   function getPermaLink($index) {
      $da = $this->list[$index];
      $da = substr($da, 0, count($da) - 4);
      return $da;
   }

   /**
    * Read given file.
    * @param type $file filename to read info from.
    * @return type HTML markup
    */
   function getPost($file) {
      
      $file = $_SERVER['DOCUMENT_ROOT']."/posts/" . $file;
      $mdown = file_get_contents($file);
      
      $tmp = new Parsedown();
      $html = $tmp->text($mdown);
      unset($tmp);
      return $html;
   }
}

function showPost() {
   $p = new posts();
   if ($_SESSION["id"][0] == "!") {
      echo $p->getPost(substr($_SESSION["id"],1) . ".md");
   } else {
      echo $p->getAtIndex($_SESSION["id"]);
   }
}

function showPermalink() {
   $p = new posts();
   echo "/" . $p->getPermaLink($_SESSION["id"]) . "/";
}

function showTweet($hashtag, $url) {
   $p = new posts();
   if (substr($url, -1) != "/") {
      $url .= "/";
   }
   echo "https://twitter.com/intent/tweet?hashtags=$hashtag&text=$url" . $p->getPermaLink($_SESSION["id"]) . "/";
}

?>