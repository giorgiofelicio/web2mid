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

if (! isset($_POST["username"]))
    die("<p>ID tidak diketahui</p>");

if (! isset($_POST["nama"]) ||
    ! isset($_POST["email"]) ||
    ! isset($_POST["password"]))
    die("<p>Data tidak lengkap</p>");

$conn = konek_db();

$username  = $_POST["username"];
$nama  = $_POST["nama"];
$email = $_POST["email"];
$password = $_POST["password"];

// periksa apakah id produk yang akan di-edit memang tersedia di database
$rows = get_produk_by_id($conn, $username);

if (! $rows)
    die("<p>Gagal query</p>");

if ($rows->num_rows == 0)
    die("<p>User $username tidak ditemukan</p>");

$image = null;
$imgname = null;
if (isset($_FILES["image"])) {
    $image = $_FILES["image"];
}

// image lama produk
$produk = $rows->fetch_object();
$oldimage = null;
if ($produk->image)
    $oldimage = $produk->image;

// ada file gambar yang diupload, ganti file gambar produk
if ($image) {
    if ($image['error'] == 0 && file_exists($image['tmp_name'])) {

        // ambil nama file
        $filename = pathinfo($image['name'], PATHINFO_FILENAME);
        // ambil nama extension file
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        // lokasi directory tempat menyimpan file yang diupload
        $path = "images";

        // hapus image lama
        if ($oldimage)
            unlink($oldimage);

        // pindahkan file upload
        $imgname = get_upload_filename($path, $filename, $ext);
        move_uploaded_file($image['tmp_name'], $imgname);
    } else if ($image['error'] != 4) {
        die("<p>Ada masalah dengan upload file</p>");
    }
}

// jika tidak ada file image yang diupload, pakai kembali oldimage
if (! $imgname)
    $imgname = $oldimage;

// update data produk
$query = $conn->prepare("update profile set nama=?, email=?, password=?, image=? where username=?");
$query->bind_param("sssss", $nama, $email, $password, $imgname, $username);
$result = $query->execute();

if ($result)
    echo "<p>Profile berhasil diupdate</p>";
else
    echo "<p>Gagal update profile</p>";
?>
    <p><a href="profile.php">Kembali ke profile</a></p>
</body>
</html>
