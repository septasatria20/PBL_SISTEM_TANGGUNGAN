<?php
// Menghubungkan ke database
include('koneksi.php');

// Pastikan session sudah dimulai
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

// Ambil nim dari session
$nim = $_SESSION['nim'];

// Query untuk mengambil data TOEIC berdasarkan nim yang sedang login
$sql = "SELECT t.toeic_id, u.nim, u.nama_lengkap, t.judul_tes, t.tanggal_ujian, t.skor, t.status
        FROM TOEIC t
        JOIN users u ON t.user_id = u.user_id
        WHERE u.nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim); // Binding parameter nim
$stmt->execute();
$result = $stmt->get_result();

// Ambil data mahasiswa yang login
$sql_user = "SELECT nama_lengkap, nim, program_studi FROM users WHERE nim = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $nim);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status TOEIC® Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
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

    /* Styling for student info */
    .ticket-header {
      margin-bottom: 20px;
    }

    /* Formatting for labels and values */
    .ticket-header div {
      margin-bottom: 10px;
    }

    .ticket-header strong {
      display: inline; /* Membuat label dan nilai berada dalam satu baris */
      width: auto;
      text-align: left;
    }

    .ticket-header p {
      display: inline; /* Membuat nilai berada di samping label */
      font-size: 18px;
      font-weight: 400;
      color: #444;
      margin: 0;
      padding-left: 5px; /* Memberikan sedikit jarak antara label dan nilai */
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
    .status-completed {
      background-color: #4caf50 !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .status-pending {
      background-color:#e63946  !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .status-in-progress {
      background-color: #f4a261 !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
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

  <!-- Main Content Section -->
  <div class="container">
    <div class="content-box">
      <h1 class="text-center">Keterangan Hasil TOEIC®</h1>
      
      <!-- Student Info -->
      <div class="ticket-header">
        <div>
          <strong>Nama:</strong><p><?php echo $user['nama_lengkap']; ?></p>
        </div>
        <div>
          <strong>NIM:</strong><p><?php echo $user['nim']; ?></p>
        </div>
        <div>
          <strong>Prodi:</strong><p><?php echo $user['program_studi']; ?></p>
        </div>
      </div>

      <!-- Ticket Table Section -->
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul Tes</th>
            <th>Tanggal Ujian</th>
            <th>Skor</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row['judul_tes'] . "</td>";
            echo "<td>" . $row['tanggal_ujian'] . "</td>";
            echo "<td>" . $row['skor'] . "</td>";
            echo "<td class='status-" . strtolower(str_replace(' ', '-', $row['status'])) . "'>" . $row['status'] . "</td>";
            echo "</tr>";
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
