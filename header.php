<?php
  session_start();
  echo "<DOCTYPE html>
          <html>
            <head>
              <meta charset='utf-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1'>
              <script src='osc.js'></script>";
  include_once 'dbfunc.php';

  $userstr = '(guest)';

  if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "($user)";
  } else {
    $loggedin = FALSE;
  }

  echo " <title>
           $appname$userstr
         </title>
         <link rel='stylesheet' href='styles.css' type='text/css' />
        </head>
        <body>
          <div class='appname'>
            $appname$userstr
          </div>";

  if ($loggedin) {
    echo "<br/><ul class='menu'>
            <li><a href='members.php?view=$user'>Home</a></li>
            <li><a href='members.php'>Members</a></li>
            <li><a href='friends.php'>Friends</a></li>
            <li><a href='messages.php'>Messages</a></li>
            <li><a href='profile.php'>Edit Profile</a></li>
            <li><a href='logout.php'>Log out</a></li></ul><br/>";
  } else {
    echo "<br/><ul class='menu'>
            <li><a href='index.php'>Home</a></li>
            <li><a href='signup.php'>Sign up</a></li>
            <li><a href='login.php'>Log in</a></li></ul><br/>
            <span class='info'>&#8658; You must be logged in to
            view this page.</span><br/><br/>";
  }
?>
