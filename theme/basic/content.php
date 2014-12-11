<article>
   <div class="fluid">
<?php
   $p = new posts();
   if ($_SESSION["id"][0] == "!") {
      echo $p->getPost(substr($_SESSION["id"],1) . ".md");
   } else {
      echo $p->getAtIndex($_SESSION["id"]);
   }
?>
     <div class="permalink">
      <a href="/<?php echo $p->getPermaLink($_SESSION["id"]); ?>/">permalink</a>, 
      <a href="https://twitter.com/intent/tweet?hashtags=MachDasWeg&text=http://corefault.de/<?php echo $p->getPermaLink($_SESSION["id"]); ?>/">tweet</a>
     </div>
   </div>
</article>

<nav class="fluid">lade nächsten beitrag</nav>