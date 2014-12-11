<?php
$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
require_once("{$ROOT}libs/posts.php");
require_once("{$ROOT}libs/Parsedown.php");

header("Content-type: application/rss+xml");

$p = new posts();

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<rss version="2.0">
   <channel>
      <title>corefault</title>
      <link>http://corefault.de</link>
      <description>ich bin nicht Schuld...</description>
      <pubDate><?php $p->getDate($p->size() - 1);?></pubDate>
      <language>de-de</language>
      <?php
      for ($i = $p->size() - 1; $i >=0; $i--) {
         //# image urls should not be relative
         $item = $p->getAtIndex($i);
         $item = ereg_replace ("src=[\"\']([^\"\']+)[\"\']","src=\"http://corefault.de\\1\"",$item);
         ?>
         <item>
            <title><?php $p->getDate($i); ?></title>
            <description><![CDATA[<?php echo $item; ?>]]></description>
            <guid isPermaLink="true">http://corefault.de/<?php echo $p->getPermaLink($i); ?>/</guid>
            <pubDate><?php echo $p->getDate($i); ?></pubDate>
         </item>
         <?php
      }
      ?>
   </channel>
</rss>
