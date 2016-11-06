<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();

if (! isset($_SESSION["username"])) {
    echo "<p><a href=\"login.php\">Login</a> terlebih dahulu</p>";
} else {
    $username = $_SESSION["username"];

    echo "<p>Hello $username</p>
	<p><a href=\"profile.php\">Profile</a></p>
    <h2>Welcome</h2>
    <p><a href=\"logout.php\">Logout</a></p>
    <a href=\"newpost.html\"><button>New Post</button>";
    
    require_once "db.php";
}
?>
</body>
</html>