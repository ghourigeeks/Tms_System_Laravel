<html>
   
   <head>
      <title>Sending HTML email using PHP</title>
   </head>
   
   <body>
      
      <?php
         ini_set("SMTP", "smtp.gmail.com");
         ini_set("sendmail_from", "aquib@geeksroot.com");
         ini_set("smtp_port", "587");
         ini_set("auth_username", "aquib@geeksroot.com");
         ini_set("auth_password", "lhXOJw&[n8@e");


         $to = "babarshaikh@outlook.com";
         $subject = "This is subject";
         
         $message = "<b>This is HTML message.</b>";
         $message .= "<h1>This is headline.</h1>";
         
         $header = "From:aquib@geeksroot.com \r\n";
         
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
      ?>
      
   </body>
</html>