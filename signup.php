<?php
  include_once 'header.php';

  echo <<<_EOL
    <script>
      // sends ajax request to check username availability
      function checkuser(user) {
        if (user.value == '') {
          O('info').innerHTML = '';
          return
        }
        params = "user=" + user.value;
        request = new ajaxRequest();
        request.open('post', 'checkuser.php', true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.setRequestHeader('Content-length', params.length);
        request.setRequestHeader('Connection', 'close');

        request.onreadystatechange = function() {
          if (this.readyState == 4)
            if (this.status == 200)
              if (this.responseText != null)
                O('info').innerHTML = this.responseText;
        }
        request.send(params)
      }

      // set a request object based on browser
      function ajaxRequest() {
        try {
          var request = new XMLHttpRequest();
        } catch(e1) {
          try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
          } catch(e2) {
            try {
              request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e3) {
              request = false;
            }
          }
        }
        return request;
      }
    </script>
    <div class='main'><h3>Please enter your details to sign up</h3>
_EOL;

  $error = "";
  $user = "";
  $pass = "";

  if (isset($_SESSION['user'])) {
    destroySession();
  }

  if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" | $pass == "") {
      $error = "Username and/or password missing <br/> <br/>";
    } else {
      if (mysqli_num_rows(queryMysql("SELECT * FROM members WHERE user='$user'"))) {
        $error = "The username is taken :(<br/><br/>";
      } else {
        queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die("<h4>Account created</h4>Please Log in.<br /><br />");
      }
    }
  }

  echo <<<_EOL
      <form method='post' action='signup.php'>
      <p class='error'>$error</p>
      <span class='fieldname'>Username</span>
      <input type='text' class='resizedText' maxlength='16' name='user'
              value='$user' onBlur='checkuser(this)'/>
      <span id='info'></span><br/>
      <span class='fieldname'>Password</span>
      <input type='password' class='resizedText' maxlength='16' name='pass'
              value='$pass'/>
      <br/><br/>
_EOL;
?>
            <span class='fieldname'>&nbsp;</span>
          <input type="submit" value="submit"/>
        </form>
      </div>
    <br/>
  </body>
</html>
