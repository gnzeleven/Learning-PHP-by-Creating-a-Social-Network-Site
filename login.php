<?php
  include_once "header.php";

  $user = "";
  $pass = "";
  $error = "";

  echo "<div class='main'><h3>Please enter your details to log in</h3>";

  if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" | $pass == "") {
      $error = "Username and/or password missing <br/> <br/>";
    } else {
      if (mysqli_num_rows(queryMysql("SELECT * FROM members WHERE user='$user' AND password='$pass'")) == 0) {
        $error = "Username and/or password is wrong. Try again.";
      } else {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die("You are logged in. Please <a href='members.php?view=$user'>click here </a>to continue.<br/><br/>");
      }
    }
  }
  echo <<<_EOL
      <form method='post' action='login.php'>
      <p class='error'> $error </p>
      <span class='fieldname'>Username</span>
      <input type='text' class='resizedText' maxlength='16' name='user' value='$user'/><br/>
      <span class='fieldname'>Password</span>
      <input type='password' class='resizedText' maxlength='16' name='pass' value='$pass'/>
      <br/>
_EOL;
?>
          <br/>
          <span class='fieldname'>&nbsp;</span>
        <input type="submit" value="login"/>
      </form>
    </div>
  <br/>
</body>
</html>
