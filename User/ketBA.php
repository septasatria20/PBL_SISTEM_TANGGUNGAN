<?php
include('koneksi.php'); // Koneksi ke database

session_start(); // Memulai sesi
$user_id = $_SESSION['user_id'];

// Mengambil data user
$sql_user = "SELECT * FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

// Mengambil data UKT untuk user
$sql_ukt = "SELECT * FROM ketUKT WHERE user_id = ?";
$stmt_ukt = $conn->prepare($sql_ukt);
$stmt_ukt->bind_param("i", $user_id);
$stmt_ukt->execute();
$ukt_result = $stmt_ukt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Bebas Tanggungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Styling Umum */
    body {
      font-family: "Open Sans", sans-serif;
      color: #333;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    /* Styling Navbar */
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

    /* Styling Box Konten */
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

    /* Styling Tabel */
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
      background: #231a6f; 
      color: #ffffff;
    }

    th, td {
      padding: 15px;
      text-align: left;
      font-size: 14px;
    }

    tbody tr:nth-child(odd) {
      background-color: #f7f7f7;
    }

    tbody tr:nth-child(even) {
      background-color: #eaeaea;
    }

    tbody tr:hover {
      background-color: #d3d3f8;
    }

    /* Status Labels */
    .status-completed, .status-pending, .status-in-progress {
      background-color: #4caf50 !important;  /* Hijau untuk status selesai */
      color: #ffffff !important;
      padding: 5px 10px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block; /* Agar lebar mengikuti teks */
      text-align: center !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .status-pending {
      background-color: #e63946 !important;  /* Merah untuk status pending */
    }

    .status-in-progress {
      background-color: #f4a261 !important;  /* Oranye untuk status in-progress */
    }


    .ticket-header {
      margin-bottom: 20px;
    }

    .ticket-header div {
      margin-bottom: 10px;
    }

    .ticket-header strong {
      margin-right: 10px;
    }

    .ticket-header div {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .ticket-header p {
      margin: 0;
      font-size: 16px;
    }

    .ticket-header h5 {
      margin: 0;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <!-- Navbar Section -->
  <nav class="custom_nav-container navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><span>Status Bebas Tanggungan</span></a>
    <div class="ms-auto">
        <a class="btn btn-danger" href="tanggungan.php"> &lt; Kembali</a>
    </div>
  </nav>

  <!-- Konten Utama -->
  <div class="container">
    <div class="content-box">
      <h1 class="text-center">Keterangan Biaya Administrasi</h1>
      <div class="ticket-header">
        <div><h5><strong>Nama:</strong> <?= $user['nama_lengkap'] ?></h5></div>
        <div><p><strong>NIM:</strong> <?= $user['nim'] ?></p></div>
        <div><p><strong>Prodi:</strong> <?= $user['program_studi'] ?></p></div>
      </div>

      <!-- Tabel Status UKT -->
      <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Akademik</th>
                <th>Tagihan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $ukt_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$row['tahun_akademik']}</td>";
                echo "<td>" . number_format($row['tagihan'], 0, ',', '.') . "</td>";
                echo "<td>{$row['tanggal']}</td>";
                echo "<td class='status-{$row['status']}'>{$row['status']}</td>";
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
