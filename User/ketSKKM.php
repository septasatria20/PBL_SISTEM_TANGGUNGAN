<?php
include('koneksi.php'); // Pastikan file koneksi.php sudah benar

// Memulai session untuk mengambil informasi user yang sedang login
session_start();

// Memeriksa apakah session user_id ada
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada session user_id, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Mendapatkan user_id dari session
$user_id = $_SESSION['user_id'];

// Query untuk mengambil data SKKM berdasarkan user_id
$query = "SELECT * FROM SKKM WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Mengambil nama lengkap, nim, dan program studi dari tabel pengguna berdasarkan user_id
$query_user = "SELECT nama_lengkap, nim, program_studi FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$nama_lengkap = $user['nama_lengkap'];
$nim = $user['nim'];
$program_studi = $user['program_studi'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Bebas Tanggungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Styling umum */
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

    /* Styling for the personal information */
    .personal-info {
      margin-bottom: 20px;
    }

    .personal-info div {
      font-size: 16px;
      margin-bottom: 10px; /* Menambahkan jarak antar elemen */
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

    .status-completed {
      background-color: #4caf50 !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
    }

    .status-pending {
      background-color: #e63946 !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
    }

    .status-in-progress {
      background-color: #f4a261 !important;
      color: #ffffff !important;
      padding: 8px 16px !important;
      border-radius: 5px !important;
      font-weight: bold !important;
      display: inline-block !important;
      text-align: center !important;
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
      <h1 class="text-center">Keterangan SKKM</h1>
      
      <!-- Informasi Pengguna -->
      <div class="personal-info">
        <div><strong>Nama:</strong> <?php echo $nama_lengkap; ?></div>
        <div><strong>NIM:</strong> <?php echo $nim; ?></div>
        <div><strong>Prodi:</strong> <?php echo $program_studi; ?></div>
      </div>

      <a href="FormSKKM.php" class="btn btn-primary">Upload Form</a>

      <!-- Ticket Table Section -->
      <table class="table">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th>Kegiatan</th>
            <th class="text-center">Semester</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Point</th>
            <th class="text-center">Status</th>
            <th class="text-center">Lampiran</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class='text-center'>" . $no++ . "</td>";
                  echo "<td>" . htmlspecialchars($row['kegiatan']) . "</td>";
                  echo "<td class='text-center'>" . htmlspecialchars($row['semester']) . "</td>";
                  echo "<td class='text-center'>" . htmlspecialchars($row['tanggal']) . "</td>";
                  echo "<td class='text-center'>" . htmlspecialchars($row['point']) . " Point</td>";
                  
                  // Kolom Status
                  echo "<td class='text-center'>";
                  if ($row['status'] == 'Selesai') {
                      echo "<span class='status-completed'>Selesai</span>";
                  } elseif ($row['status'] == 'Pending') {
                      echo "<span class='status-pending'>Pending</span>";
                  } else {
                      echo "<span class='status-in-progress'>Belum Selesai</span>";
                  }
                  echo "</td>";

                  // Kolom Lampiran
                  if (!empty($row['lampiran'])) {
                      echo "<td class='text-center'><a href='uploads/skkm/" . htmlspecialchars($row['lampiran']) . "' target='_blank'>Lihat Lampiran</a></td>";
                  } else {
                      echo "<td class='text-center'>Tidak Ada Lampiran</td>";
                  }

                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='text-center'>Belum ada data SKKM.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
