<?php
session_start(); // Memulai sesi
include('koneksi.php'); // Koneksi ke database

// Query untuk mendapatkan semua data kompensasi
$query_kompen = "SELECT k.*, u.nama_lengkap, u.nim, u.program_studi AS jurusan, k.mata_kuliah AS prodi 
                 FROM kompen k 
                 INNER JOIN users u ON k.user_id = u.user_id";
$result_kompen = $conn->query($query_kompen);

// Menangani aksi verifikasi/tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kompen_id = $_POST['kompen_id'];
    $action = $_POST['action'];

    // Update status berdasarkan aksi
    if ($action === 'verify') {
        $update_status = "UPDATE kompen SET status = 'Selesai' WHERE kompen_id = ?";
    } elseif ($action === 'reject') {
        $update_status = "UPDATE kompen SET status = 'Belum Terpenuhi' WHERE kompen_id = ?";
    }

    $stmt = $conn->prepare($update_status);
    $stmt->bind_param("i", $kompen_id);
    $stmt->execute();

    // Redirect untuk mencegah form resubmission
    header("Location: ketKompen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Verifikasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Open Sans", sans-serif;
      color: #333;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
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

    .filters {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .filters input, .filters select {
      border-radius: 5px;
      border: 1px solid #ddd;
      padding: 8px;
      width: 100%;
    }

    .filters .filter-box {
      flex: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 10px 0;
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
    
    table td:nth-child(7), 
    table th:nth-child(7) {
      text-align: left;
      vertical-align: left;
    }

    tbody tr:nth-child(even) {
      background-color: #eaeaea;
    }

    tbody tr:hover {
      background-color: #d3d3f8;
    }

    .status-completed {
      background-color: #4caf50;
      color: #2a9d8f;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-align: left;
    }

    .status-rejected {
      background-color: #c34040;
      color: #c34040;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-align: left;
    }

    .status-pending {
      background-color: #e63946;
      color: #e3a71c;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
      text-align: left;
    }

    .btn-verify {
      background-color: #2a9d8f;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
    }

    .btn-reject {
      background-color: #c34040;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
    }

    .btn-edit {
      background-color: #e3a71c;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      display: none;
    }

    .btn-verify:hover {
      background-color: #21867a;
    }

    .btn-reject:hover {
      background-color: #a33030;
    }
  </style>
</head>
<body>

  <nav class="custom_nav-container navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><span>Verifikasi Kompensasi</span></a>
    <div class="ms-auto">
      <a class="btn btn-danger" href="AdminAkademik.php">&lt; Keluar</a>
    </div>
  </nav>

  <div class="container">
    <div class="content-box">
      <h1 class="text-center">Daftar Mahasiswa</h1>

      <div class="filters">
        <div class="filter-box">
          <input type="text" id="searchInput" placeholder="Cari berdasarkan Nama atau NIM" onkeyup="filterTable()">
        </div>
        <div class="filter-box">
          <select id="sortSelect" onchange="sortTable()">
            <option value="no">Urutkan Berdasarkan</option>
            <option value="nama">Nama</option>
            <option value="nim">NIM</option>
          </select>
        </div>
        <div class="filter-box">
          <select id="filterJurusan" onchange="filterByJurusan()">
            <option value="">Filter Berdasarkan Jurusan</option>
            <option value="Teknik Mesin">Teknik Mesin</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
            <option value="Teknologi Informasi">Teknologi Informasi</option>
            <option value="Teknik Sipil">Teknik Sipil</option>
            <option value="Teknik Kimia">Teknik Kimia</option>
            <option value="Akuntansi">Akuntansi</option>
            <option value="Administrasi Niaga">Administrasi Niaga</option>
          </select>
        </div>
      </div>

      <table id="studentTable" class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>NIM</th>
      <th>Jurusan</th>
      <th>Prodi</th>
      <th>Pekerjaan</th>
      <th>Jam</th>
      <th>Semester</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    while ($row = $result_kompen->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$no}</td>";
        echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prodi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pekerjaan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['durasi_kompensasi']) . " Jam</td>";
        echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";

        // Kolom Status
        echo "<td>";
        if ($row['status'] === 'Selesai') {
            echo "<span class='badge bg-success'>Selesai</span>";
        } elseif ($row['status'] === 'Belum Terpenuhi') {
            echo "<span class='badge bg-warning'>Belum Terpenuhi</span>";
        } else {
            echo "<span class='badge bg-info'>Sedang Diproses</span>";
        }
        echo "</td>";

        // Kolom Aksi
        echo "<td>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='kompen_id' value='{$row['kompen_id']}'>
                <input type='hidden' name='action' value='verify'>
                <button type='submit' class='btn btn-success btn-sm'>Verifikasi</button>
            </form>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='kompen_id' value='{$row['kompen_id']}'>
                <input type='hidden' name='action' value='reject'>
                <button type='submit' class='btn btn-danger btn-sm'>Tolak</button>
            </form>
        </td>";
        echo "</tr>";
        $no++;
    }
    ?>
  </tbody>
</table>

    </div>
  </div>

  <div class="modal" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tolak Dokumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Pilih alasan menolak dokumen:</p>
          <select id="rejectReason" class="form-select">
            <option value="">Pilih Alasan</option>
            <option value="Dokumen tidak sesuai format">Dokumen tidak sesuai format</option>
            <option value="Data tidak sesuai">Data tidak sesuai</option>
            <option value="Informasi tidak lengkap">Informasi tidak lengkap</option>
            <option value="Dokumen rusak/tidak dapat dibuka">Dokumen rusak/tidak dapat dibuka</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" onclick="reject()">Tolak</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function filterTable() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#studentTable tbody tr');

      rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const nim = row.cells[2].textContent.toLowerCase();

        if (name.includes(input) || nim.includes(input)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function sortTable() {
    const table = document.getElementById('studentTable');
    const rows = Array.from(table.rows).slice(1);
    const sortBy = document.getElementById('sortSelect').value;

    rows.sort((a, b) => {
      let colIndex;

      if (sortBy === 'nama') {
        colIndex = 1;
      } else if (sortBy === 'nim') {
        colIndex = 2;
      } else if (sortBy === 'jurusan') {
        colIndex = 3;
      } else if (sortBy === 'no') {
        colIndex = 0;
      }

      const valA = a.cells[colIndex].textContent.trim();
      const valB = b.cells[colIndex].textContent.trim();

      if (colIndex === 0) {
        return parseInt(valA) - parseInt(valB);
      }

       return valA.localeCompare(valB);
     });

    rows.forEach(row => table.tBodies[0].appendChild(row));
   }

    function filterByJurusan() {
      const selectedJurusan = document.getElementById('filterJurusan').value;
      const rows = document.querySelectorAll('#studentTable tbody tr');

      rows.forEach(row => {
        const jurusan = row.cells[3].textContent;

        if (selectedJurusan === '' || jurusan === selectedJurusan) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    let currentRow = null;

    function verify(button) {
      const row = button.parentElement.parentElement;
      const statusCell = row.querySelector('td:nth-child(10)');
      statusCell.textContent = 'Terverifikasi';
      statusCell.className = 'status-completed';

      button.style.display = 'none';
      const rejectButton = row.querySelector('.btn-reject');
      rejectButton.style.display = 'none';

      row.querySelector('.btn-edit').style.display = 'inline-block';
    }

    function openRejectModal(button) {
      currentRow = button.parentElement.parentElement;
      const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
      modal.show();
    }

    function reject() {
      const reason = document.getElementById('rejectReason').value;

      if (!reason) {
        alert('Pilih alasan penolakan terlebih dahulu!');
        return;
      }

      const statusCell = currentRow.querySelector('td:nth-child(10)');
      statusCell.textContent = `Ditolak: ${reason}`;
      statusCell.className = 'status-rejected';

      const rejectButton = currentRow.querySelector('.btn-reject');
      rejectButton.style.display = 'none';

      currentRow.querySelector('.btn-verify').style.display = 'none';

      currentRow.querySelector('.btn-edit').style.display = 'inline-block';

      const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
      modal.hide();
    }

    function editStatus(button) {
      const row = button.parentElement.parentElement;
      const statusCell = row.querySelector('td:nth-child(10)');
      statusCell.textContent = 'Belum Diverifikasi';
      statusCell.className = 'status-pending';

      const verifyButton = row.querySelector('.btn-verify');
      verifyButton.style.display = 'inline-block';
      verifyButton.textContent = 'Verifikasi';

      const rejectButton = row.querySelector('.btn-reject');
      rejectButton.style.display = 'inline-block';
      rejectButton.textContent = 'Tolak';

      button.style.display = 'none';
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
