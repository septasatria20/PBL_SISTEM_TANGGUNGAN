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

// Mengambil nama lengkap, nim, dan program studi dari tabel pengguna berdasarkan user_id
$query_user = "SELECT nama_lengkap, nim, program_studi FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

if ($user) {
    $nama_lengkap = $user['nama_lengkap'];
    $nim = $user['nim'];
    $program_studi = $user['program_studi'];
} else {
    echo "User tidak ditemukan.";
    exit();
}

// Mengambil data tugas_akhir berdasarkan user_id
$query_ta = "SELECT judul_tugas_akhir, abstrak, lampiran_dokumen, status_verifikasi FROM tugas_akhir WHERE user_id = ?";
$stmt_ta = $conn->prepare($query_ta);
$stmt_ta->bind_param("i", $user_id);
$stmt_ta->execute();
$result_ta = $stmt_ta->get_result();



$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Bebas Tanggungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
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
    
  </style>
</head>
<body>

  <!-- Navbar Section -->
  <nav class="custom_nav-container navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php"><span>Status Bebas Tanggungan</span></a>
    <div class="ms-auto">
        <a class="btn btn-danger" href="tanggungan.php"> &lt; Kembali</a>
    </div>
  </nav>

  <!-- Main Content Section -->
  <div class="container">
    <div class="content-box">
      <h1 class="text-center">Keterangan Tugas Akhir</h1>
      <div class="ticket-header">
        <div><strong>Nama:</strong> <?php echo $nama_lengkap; ?></div>
        <div><strong>NIM:</strong> <?php echo $nim; ?></div>
        <div><strong>Prodi:</strong> <?php echo $program_studi; ?></div>
        <a href="FormTA.php" class="btn btn-primary">Upload Form</a>
      </div>
      <table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Judul Tugas Akhir</th>
      <th>Abstrak</th>
      <th>Status</th>
      <th>Lampiran</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php while ($row = $result_ta->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['judul_tugas_akhir']) ?></td>
        <td><?= htmlspecialchars($row['abstrak']) ?></td>
        <td>
          <?php
          switch ($row['status_verifikasi']) {
              case 'Disetujui':
                  echo '<span class="status-completed">Disetujui</span>';
                  break;
              case 'Ditolak':
                  echo '<span class="status-rejected">Ditolak</span>';
                  break;
              default:
                  echo '<span class="status-pending">Pending</span>';
          }
          ?>
        </td>
        <td>
          <a href="uploads/<?= htmlspecialchars($row['lampiran_dokumen']) ?>" class="btn btn-info btn-sm">Lihat</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

      </div>
    </div>
  </div>

</body>
</html>
