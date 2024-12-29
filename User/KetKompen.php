<?php
session_start(); // Memulai sesi

include('koneksi.php'); // Koneksi ke database

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    die("User belum login. Harap login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan data pengguna
$query_user = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();
$user_data = $result_user->fetch_assoc();

if (!$user_data) {
    die("Pengguna tidak ditemukan.");
}

// Query untuk mendapatkan data kompensasi
$query_kompen = "SELECT * FROM kompen WHERE user_id = ?";
$stmt = $conn->prepare($query_kompen);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_kompen = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Bebas Tanggungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Styling lainnya tetap sama */
  </style>
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Bebas Tanggungan</title>
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
  background-color:  #e63946 !important;  /* Oranye untuk status pending */
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
      <h1 class="text-center">Keterangan Kompensasi</h1>
      <div class="ticket-header">
        <h5><strong>Nama  :</strong> <?php echo $user_data['nama_lengkap']; ?></h5>
        <p><strong>NIM    :</strong> <?php echo $user_data['nim']; ?> </p>
        <p><strong>Prodi  :</strong> <?php echo $user_data['program_studi']; ?></p>
        <a href="FormKompen.php" class="btn btn-primary">Upload Form</a>
      </div>

      <!-- Ticket Table Section -->
      <table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Semester</th>
      <th>Tanggal</th>
      <th>Pekerjaan</th>
      <th>Durasi (Jam)</th>
      <th>Status</th>
      <th>Lampiran</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    while ($kompen = $result_kompen->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$no}</td>";
        echo "<td>" . htmlspecialchars($kompen['semester']) . "</td>";
        echo "<td>" . htmlspecialchars($kompen['tanggal']) . "</td>";
        echo "<td>" . htmlspecialchars($kompen['pekerjaan']) . "</td>";
        echo "<td>" . htmlspecialchars($kompen['durasi_kompensasi']) . " Jam</td>";

        // Status
        echo "<td>";
        if ($kompen['status'] === 'Selesai') {
            echo "<span class='badge bg-success'>Selesai</span>";
        } elseif ($kompen['status'] === 'Belum Terpenuhi') {
            echo "<span class='badge bg-warning'>Belum Terpenuhi</span>";
        } else {
            echo "<span class='badge bg-info'>Sedang Diproses</span>";
        }
        echo "</td>";

        // Lampiran
        if (!empty($kompen['file_path'])) {
            echo "<td><a href='uploads/" . htmlspecialchars($kompen['file_path']) . "' target='_blank'>Lihat File</a></td>";
        } else {
            echo "<td>Tidak ada file</td>";
        }

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

