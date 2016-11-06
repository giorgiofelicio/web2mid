<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DELETE PROFILE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "db.php";

if (! isset($_GET["username"]))
    die("<p>User tidak diketahui</p>");

$conn = konek_db();

$username = $_GET["username"];

// periksa apakah id produk yang akan di-hapus memang tersedia di database
$rows = get_produk_by_id($conn, $username);

if (! $rows)
    die("<p>Gagal query</p>");

if ($rows->num_rows == 0)
    die("<p>User $username tidak ditemukan</p>");

// ambil image produk, jika ada file image, hapus file image produk
$produk = $rows->fetch_object();
if ($produk->image)
    unlink($produk->image);

// delete data produk
$query = $conn->prepare("delete from profile where username=?");
$query->bind_param("s", $username);
$result = $query->execute();

if ($result)
    echo "<p>User berhasil dihapus</p>";
else
    echo "<p>Gagal hapus data produk</p>";
?>
    <p><a href="login.php">Kembali ke login</a></p>
</body>
</html>
