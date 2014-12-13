# markdownblog

simple blog engine with markdown support. all data will be stored as markdown files.
includes direct posting.

## basic version

* default theme
* use "create" for new post (uploading images supported)

## extended version

* support for different themes
    * copy the theme folder and change the files you want
    * update $_theme path variable in index.php

## create custom template

* copy the theme/basic folder and rename.
* in index.php set the $_theme variable to the new folder
* adjust your style.css and content.php

you can use the following functions to get information:

* showPost() to get the current post data
* showPermalink() to get a link to be used as static link to this post
* showTweet(hashtag, url) to prepare a link to tweet the post link with some info
