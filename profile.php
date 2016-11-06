<!DOCTYPE html>
<html>
<head>
	<title>PROFILE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "db.php";
    // buka koneksi ke database -- menggunakan mysqli
    $conn = konek_db();

    // query seluruh data produk dari database
    $query = $conn->prepare("select * from profile");
    $result = $query->execute();

    if (! $result)
        die("Gagal query");

    // baca hasil query menjadi object result set
    $rows = $query->get_result();

    // loop setiap baris result set sebagai object
    if($row = $rows->fetch_object()) {
        $url_edit   = "edit.php?username=$row->username";

        $image = "images/people.png";
        if ($row->image != null)
            $image = $row->image;
        
        echo "<img src=\"$image\"><br>";
        echo "$row->username<br>";
        echo "$row->nama<br>";
        echo "<a href=\"$url_edit\"><button>Edit</button></a>";
    }
?>
</body>
</html>