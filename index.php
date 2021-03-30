<?php
  include_once "header.php";
  echo "<br/>
          <span class='main'> Welcome to Old School Cool, ";
  if ($loggedin) {
    echo "$user";
  } else {
    echo "please sign up and/or log in";
  }
?>
      </span>
    <br/>
  </body>
</html>
        
