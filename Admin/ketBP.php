<?php
include('koneksi.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peminjaman_id = $_POST['peminjaman_id'];
    $status = $_POST['status'];

    $query = "UPDATE perpustakaan SET status = ? WHERE peminjaman_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $peminjaman_id);
    $stmt->execute();

    header("Location: ketBP_admin.php");
    exit();
}

// Ambil data peminjaman
$query = "SELECT * FROM perpustakaan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Perpustakaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Open Sans", sans-serif;
      color: #333;
      background-color: #f9f9f9;
    }

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

    .status-returned {
      background-color: #4caf50;
      color: #ffffff;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
    }

    .status-borrowed {
      background-color: #e63946;
      color: #ffffff;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
    }

    .btn-return {
      background-color: #2a9d8f;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
    }

    .btn-return:hover {
      background-color: #21867a;
    }
  </style>
</head>
<body>

  <!-- Navbar Section -->
  <nav class="custom_nav-container navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><span>Admin Perpustakaan</span></a>
    <div class="ms-auto">
      <a class="btn btn-danger" href="index_perpustakaan.html">&lt; Keluar</a>
    </div>
  </nav>

  <!-- Main Content Section -->
  <div class="container">
    <div class="content-box">
      <h1 class="text-center">Daftar Peminjaman Buku</h1>
      <!-- Table of Borrowed Books -->
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['judul_buku'] . "</td>";
                    echo "<td>" . $row['kategori'] . "</td>";
                    echo "<td>" . $row['tgl_peminjaman'] . "</td>";
                    echo "<td>" . $row['tgl_pengembalian'] . "</td>";
                    echo "<td>Rp " . number_format($row['denda'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' style='display:inline-block;'>";
                    echo "<input type='hidden' name='peminjaman_id' value='" . $row['peminjaman_id'] . "'>";
                    echo "<button type='submit' name='status' value='Selesai' class='btn btn-success btn-sm'>Verifikasi</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
  </div>

  <script>
    function returnBook(button) {
      // Get the row containing the clicked button
      const row = button.parentElement.parentElement;

      // Update the status cell
      const statusCell = row.querySelector('td:nth-child(7)');
      const returnDate = row.querySelector('td:nth-child(6)').textContent;
      const dueDate = new Date(returnDate);
      const today = new Date();

      // Calculate overdue days
      const diffTime = today - dueDate;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      let fine = 0;

      if (diffDays > 0) {
        fine = diffDays * 1000; // Rp 1000 per day
      }

      // Update the fine cell
      const fineCell = row.querySelector('td:nth-child(8)');
      fineCell.textContent = fine > 0 ? `Rp ${fine}` : 'Rp 0';

      // Update status
      statusCell.textContent = 'Dikembalikan';
      statusCell.className = 'status-returned';

      // Disable the button
      button.textContent = 'Sudah Dikembalikan';
      button.disabled = true;
      button.style.backgroundColor = '#ccc';
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Kegiatan</th>
      <th>Semester</th>
      <th>Tanggal</th>
      <th>Point</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>01</td>
      <td>LDKK</td>
      <td>Semester 1</td>
      <td>2023-07-05</td>
      <td> 5 Point</td>
      <td class="status-completed">Selesai</td>
    </tr>
    <tr>
      <td>02</td>
      <td>Orientasi pendidikan</td>
      <td>Semester 1</td>
      <td>2023-07-19</td>
      <td> 2 Point</td>
      <td class="status-completed">Selesai</td>
    </tr>
    <tr>
      <td>03</td>
      <td>Mentoring Keagamaan</td>
      <td>Semester 1</td>
      <td>2023-07-29</td>
      <td> 2 Point</td>
      <td class="status-completed">Selesai</td>
    </tr>
    <tr>
      <td>04</td>
      <td>Seminar Nasional UKM BKM</td>
      <td>Semester 1</td>
      <td>2023-09-05</td>
      <td> 1 Point</td>
      <td class="status-completed">Selesai</td>
    </tr>
    <tr>
      <td>05</td>
      <td>Seminar Nasional UKM PP</td>
      <td>Semester 1</td>
      <td>2023-10-12</td>
      <td> 2 Point</td>
      <td class="status-completed">Selesai</td>
    </tr>
  </tbody>
</table>