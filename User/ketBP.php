<?php
// Sertakan file koneksi.php
require_once "koneksi.php"; // Pastikan path ini sesuai dengan struktur file Anda

// Pastikan user sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Jika belum login, arahkan ke halaman login
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Ambil data user dari tabel 'users' berdasarkan user_id
$sql_user = "SELECT * FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// Cek apakah data pengguna ditemukan
if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    die("Data pengguna tidak ditemukan.");
}

// Ambil data peminjaman buku berdasarkan user_id
$sql_perpustakaan = "SELECT * FROM perpustakaan WHERE user_id = ?";
$stmt_perpustakaan = $conn->prepare($sql_perpustakaan);
$stmt_perpustakaan->bind_param("i", $user_id);
$stmt_perpustakaan->execute();
$result_perpustakaan = $stmt_perpustakaan->get_result();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* General Body Styling */
 /* General Body Styling */
/* General Body Styling */
/* General Body Styling */
body {
      font-family: "Open Sans", sans-serif;
      color: #333;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    /* Navbar Styling */
    .custom_nav-container {
      background: #231a6f;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .navbar-brand span {
      font-weight: bold;
      font-size: 26px;
      color: #ffffff;
    }

    .btn-danger {
      color: #fff;
      background-color: #e63946;
      border: none;
    }

    /* Content Box Styling */
    .content-box {
      padding: 30px;
      margin: 30px auto;
      border-radius: 15px;
      background: #ffffff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .content-box h1 {
      font-weight: bold;
      font-size: 28px;
      color: #2a237a;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Table Styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    thead {
      background: #231a6f; /* Gradien biru dan ungu */
      color: #ffffff;
    }

    th, td {
      padding: 15px;
      text-align: left;
      font-size: 14px;
    }

    tbody tr:nth-child(odd) {
      background-color: #f7f7f7; /* Warna abu-abu terang */
    }

    tbody tr:nth-child(even) {
      background-color: #eaeaea; /* Warna abu-abu sedikit lebih gelap */
    }

    tbody tr:hover {
      background-color: #d3d3f8; /* Efek hover biru lembut */
    }

/* Status Labels */
/* Status Labels */
.status-completed {
  background-color: #4caf50 !important;  /* Hijau untuk status selesai */
  color: #ffffff !important;
  padding: 8px 16px !important;
  border-radius: 5px !important;
  font-weight: bold !important;
  display: inline-block !important;
  text-align: center !important;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
}

.status-pending {
  background-color:#e63946  !important;  /* Oranye untuk status pending */
  color: #ffffff !important;
  padding: 8px 16px !important;
  border-radius: 5px !important;
  font-weight: bold !important;
  display: inline-block !important;
  text-align: center !important;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
}

.status-in-progress {
  background-color: #f4a261 !important;  /* Merah untuk status in-progress */
  color: #ffffff !important;
  padding: 8px 16px !important;
  border-radius: 5px !important;
  font-weight: bold !important;
  display: inline-block !important;
  text-align: center !important;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
}

/* Styling for text elements in ticket-header */
.ticket-header h5, .ticket-header p {
  font-size: 18px;
  font-weight: 400;
  color: #444;
  margin: 8px 0; /* Menambahkan jarak yang konsisten antar baris */
  line-height: 1.6;
}

        /* Styling untuk status selesai dan belum kembali */
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #231a6f;">
        <a class="navbar-brand" href="#"><span style="font-weight: bold; font-size: 26px; color: white;">Status Peminjaman Buku</span></a>
        <div class="ms-auto">
            <a class="btn btn-danger" href="tanggungan.php"> &lt; Kembali</a>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container">
        <div class="content-box">
            <h1 class="text-center">Keterangan Peminjaman Buku</h1>
            <div class="ticket-header">
                <div><h5><strong>Nama:</strong> <?php echo $user['nama_lengkap']; ?></h5></div>
                <div><p><strong>NIM:</strong> <?php echo $user['nim']; ?></p></div>
                <div><p><strong>Program Studi:</strong> <?php echo $user['program_studi']; ?></p></div>
            </div>

            <!-- Ticket Table Section -->
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Tgl Peminjaman</th>
                        <th>Tgl Pengembalian</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Loop untuk menampilkan data peminjaman buku
                    while ($row = $result_perpustakaan->fetch_assoc()) { // Menggunakan $result_perpustakaan
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>" . htmlspecialchars($row['judul_buku']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tgl_peminjaman']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tgl_pengembalian']) . "</td>";
                        echo "<td>Rp " . number_format($row['denda'], 0, ',', '.') . "</td>";
                        echo "<td class='" . ($row['status'] === 'Selesai' ? 'status-completed' : 'status-pending') . "'>" . htmlspecialchars($row['status']) . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
