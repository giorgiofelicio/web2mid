<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contoh database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "db.php";

if (! isset($_GET["username"]))
    die("<p>ID produk tidak diketahui</p>");

$conn = konek_db();

$username = $_GET["username"];
//
// periksa apakah id produk yang akan di-hapus imagenya memang tersedia di database
$rows = get_produk_by_id($conn, $username);

if (! $rows)
    die("<p>Gagal query</p>");

if ($rows->num_rows == 0)
    die("<p>User $username tidak ditemukan</p>");

// image lama produk
$produk = $rows->fetch_object();
$oldimage = null;
if ($produk->image)
    $oldimage = $produk->image;

if ($oldimage) {
    unlink($oldimage);
    $query = $conn->prepare("update profile set image=null where username=?");
    $query->bind_param("s", $username);

    $result = $query->execute();

    if ($result)
        echo "<p>Image produk berhasil dihapus</p>";
    else
        echo "<p>Gagal hapus image produk</p>";
}
header("Location: profile.php");
?>
</body>
</html>
