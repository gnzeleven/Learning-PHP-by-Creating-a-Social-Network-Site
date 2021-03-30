<?php
  include 'config.php';

  // Connect to mysql server
  $con = mysqli_connect($dbhost, $dbuser, $dbpassword);
  if (!$con){
    die(mysql_error());
  }
  else{
    echo "<script>
            console.log('Connected to $dbhost')
          </script>";
  }

  // Select the database
  mysqli_select_db($con, $dbname) or die(mysql_error());

  // Create a table
  function createTable($tableName, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $tableName($query)");
    echo "Table $tableName created! <br/>";
  }

  // Helper function to execute a query
  function queryMysql($query){
    global $con;
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    return $result;
  }

  // Function to destroy session
  function destroySession(){
    // clear the values of $_SESSION to empty array
    $_SESSION = array();
    if(session_id() != "" || isset($_COOKIE[session_name()])){
      setcookie(session_name(), '', time()-2592000, '/');
    }
    session_destroy();
  }

  // Function to sanitize strings to prevent SQL injections
  function sanitizeString($var) {
    global $con;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    $var = mysqli_real_escape_string($con, $var);
    return $var;
  }

  // Query an existing user
  function showProfile($user) {
    if (file_exists("$user.jpg")) {
      echo "<img src='$user.jpg' align='left' />";
    }
    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
    $num_rows = mysqli_num_rows($result);
    if ($num_rows) {
      $row = mysqli_fetch_row($result);
      echo stripslashes($row[1]) . "<br clear=left /><br/>";
    }
  }
?>
