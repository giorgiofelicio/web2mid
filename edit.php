<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EDIT PROFILE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Profile</h1>    
<?php
require_once "db.php";

if (! isset($_GET["username"]))
    die("<p>User tidak ditemukan</p>");

$conn = konek_db();

$username = $_GET["username"];

// periksa apakah id produk yang akan di-edit memang tersedia di database
$rows = get_produk_by_id($conn, $username);

if (! $rows)
    die("<p>Gagal query</p>");

if ($rows->num_rows == 0)
    die("<p>User $username tidak ditemukan</p>");

// tarik data dari result set ke object
$row = $rows->fetch_object();
$username = $row->username;
$nama = $row->nama;
$email = $row->email;
$password = $row->password;
$image = "images/people.png";
if ($row->image)
    $image = $row->image;
?>

    <form method="post" action="update.php?username=<?php echo $username; ?>" enctype="multipart/form-data">
        <div>
            <label>Username:</label>
            <input type="text" name="username" placeholder="Username" 
                value="<?php echo $username; ?>">
        </div>
        <div>
            <label>Nama:</label>
            <input type="text" name="nama" placeholder="Nama" 
                value="<?php echo $nama; ?>">
        </div>
        <div>
            <label>Email:</label>
            <input type="text" name="email" placeholder="Email" 
                value="<?php echo $email; ?>">
        </div>
        <div>
            <label>Password:</label>
            <input type="text" name="password" placeholder="Password" 
                value="<?php echo $password; ?>">
        </div>
        <div>
            <label>Image Produk:</label>
            <input type="file" name="image" accept="image/*"><br>
            <img src="<?php echo $image; ?>">
            <a href="delete_image.php?username=<?php echo $username; ?>"><button type="button">Hapus Image</button></a>
        </div>
        <div>
            <input type="submit" value="Update">
            <a href="profile.php"><button type="button">Batal</button></a>
            <a href="delete.php?username=<?php echo $username; ?>"><button type="button">Delete</button></a>
        </div>
    </form>

</body>
</html>
