<?php
require_once "db.php";
session_start();

if (isset($_SESSION["username"]))
    header("Location: home.php");

if (isset($_POST["username"]) &&
    isset($_POST["password"])) {

  	$username = $_POST["username"];
    $password = $_POST["password"];

	$conn = konek_db();
	$query = $conn->prepare("select * from profile where username=? and password=?");
	$query ->bind_param("ss", $username, $password);
	$result = $query->execute();

	if(! $result)
		die("Gagal query");

	$rows = $query->get_result();
	if($rows->num_rows == 1) {
		$_SESSION["username"] = $username;
		header("Location: home.php");
	}

    $pesan = "<p>Username/Password salah</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
    <style>
    	.wrap {
	margin: 0 auto;
	width: 500px;
	height: 200px;
	background: green;
	text-align: center;
	margin-top: 50px;
}
    </style>
</head>
<body>
	<div class="wrap">
	<form method="post" action="login.php">
		<h2>LOGIN</h2>
		<div>
		<label for="username">Username</label>
		<input type="text" id="username" name="username">
		</div>
		<div>
		<label for="username">Password</label>
		<input type="password" id="password" name="password">
		</div>
		<?php if (isset($pesan))
                echo $pesan;
        ?>
		<div><input type="submit" value="Login"></div>

		<p>Doesn't have an account yet? <a href="register.html">Register!</a></p>
	</form>
	</div>
</body>
</html>