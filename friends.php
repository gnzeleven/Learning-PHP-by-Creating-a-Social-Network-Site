<?php
include_once "header.php";

if (!$loggedin) {
  die();
}

if (isset($_GET['view'])) {
  $view = sanitizeString($_GET['view']);
} else {
  $view = $user;
}

if ($view == $user) {
  $name1 = $name2 = "Your";
  $name3 = "You are";
} else {
  $name1 = "<a href='members.php?view=$view'>$view</a>'s";
  $name2 = "$view's";
  $name3 = "$view is";
}

echo "<div class='main'>";

$followers = array();
$following = array();

$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
$num = mysqli_num_rows($result);

for ($i=0; $i<$num; ++$i) {
  $row = mysqli_fetch_row($result);
  $followers[$i] = $row[1];
}

$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
$num = mysqli_num_rows($result);

for ($i=0; $i<$num; ++$i) {
  $row = mysqli_fetch_row($result);
  $following[$i] = $row[0];
}

$mutual = array_intersect($followers, $following);
$followers_only = array_diff($followers, $mutual);
$following_only = array_diff($following, $mutual);
$friends = FALSE;

if (sizeof($mutual)) {
  echo "<span class='subhead'>$name2 mutual friends</span><ul>";
  foreach($mutual as $friend) {
    echo "<li><a href='members.php?view=$friend'>$friend</a>";
  }
  echo "</ul>";
  $friends = TRUE;
}

if (sizeof($followers_only)) {
  echo "<span class='subhead'>$name2 followers</span><ul>";
  foreach($followers_only as $friend) {
    echo "<li><a href='members.php?view=$friend'>$friend</a>";
  }
  echo "</ul>";
  $friends = TRUE;
}

if (sizeof($following_only)) {
  echo "<span class='subhead'>$name3 following</span><ul>";
  foreach($following_only as $friend) {
    echo "<li><a href='members.php?view=$friend'>$friend</a>";
  }
  echo "</ul>";
  $friends = TRUE;
}

if (!$friends) {
  echo "<br/> You don't have any friends yet. <br/><br/>";
}

echo "<a class='button' href='messages.php?view=$view'>View $name2 messages</a>";
?>
      </div>
    <br/>
  <body/>
<html/>
