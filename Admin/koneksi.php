<?php
// koneksi.php
$servername = "localhost";  // Nama server database (biasanya localhost)
$username = "root";         // Username database
$password = "";             // Password database
$dbname = "sistem_tanggungan";  // Nama database yang digunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
