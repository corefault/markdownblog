/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function stopUpload(value) {
   var val = $('#meta textarea').val();
   val = value + "\r\n" + val;
   $('#meta textarea').val(val);
}
function Markdown() {
   var md = $('#meta textarea').val();
   md = md.replace(/^# ([^\n]+)/g, "<h1>$1</h1>");
   md = md.replace(/\r\n/g, "\n");
   md = md.replace(/\n\n/g, "<p>");
   md = md.replace(/\*\*([^*]+)\*\*/g, "<strong>$1</strong>");
   md = md.replace(/\*([^*]+)\*/g, "<em>$1</em>");
   md = md.replace(/!\[([^\]]+)\]\(([^\)]+)\)/g, "<img src='$2' alt='$1'>");
   md = md.replace(/\[([^\]]+)\]\(([^\)]+)\)/g, "<a href='$2'>$1</a>");
   return md;
}
var wysiwyg = {
   initialize: function() {
      var o = "<div id='meta'>" +
              "<form id='imageupload' action='meta.php?image=1' method='post' enctype='multipart/form-data' target='upload_target'>" + 
				  "<input name='file' type='file'>" +
              "<iframe id='upload_target' name='upload_target' src='#' style='width:0;height:0;border:0px solid #fff;'></iframe>" + 
              "</form>" + 
              "<form action='meta.php?create=1' method='post'>" +
              "<textarea rows='10' name='md'>[quelle](url)</textarea>" + 
              "<input type='submit' id='upload' value='create' />" + 
              "</form>" + 
              "<article></article>";
      
      $('body').append(o);
      $('input[name=file]').on("change", function () {
         $('#imageupload').submit();
         /*var val = $('#meta textarea').val();
         val = "![alt]($1)\r\n" + val;
         $('#meta textarea').val(val);*/
      });

      $('#meta textarea').on("keydown", function () {
         $('#meta article').html(Markdown());
      });
      this.update();
   }
};

var meta = {
   allowed: false,
   index: 0,
   pattern: [67, 82, 69, 65, 84, 69],
   initialize: function() {
      document.onkeydown = function(e) {
         var active = document.activeElement;
         meta.allowed = (active.nodeName !== "TEXTAREA" && active.nodeName !== "INPUT");
         meta.handle(e);
      }
   },
   handle: function(e) {
      if (!this.allowed) {
         return;
      }
      if (!e) {
         e = window.event;
      }
      var code = e.charCode ? e.charCode : e.keyCode;
      if (!e.shiftKey && !e.ctrlKey && !e.altKey && !e.metaKey) {
         if (this.pattern[this.index] == code) {
            this.index++;
            if (this.index >= this.pattern.length) {
               this.index = 0;
               wysiwyg.initialize();
            }
         } else {
            this.index = 0;
         }
      }
   }
};

function scrollcheck() {
   //# check if reloader is in visible area
   var b = $(window).scrollTop();
   var o = $("nav").offset();
   var y = o.top;
   var th = $("nav").height();
   var wh = $(window).height();
   if (y + th >= b && y <= b + wh) {
      $("nav").remove();
      $.ajax({url: "index.php?q=",
         success: function(data) {
            if (data.indexOf("<p>") != -1) {
               $("body").append(data);
            }
         }
      });
   }
}

$(document).ready(function() {

   meta.initialize();
   scrollcheck(); // check if a second post will fit on screen

   $(window).scroll(function() {
      scrollcheck();
   });
});

