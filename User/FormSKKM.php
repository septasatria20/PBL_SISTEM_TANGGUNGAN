<?php
session_start();
include('koneksi.php'); // Koneksi ke database

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database berdasarkan user_id
$query_user = "SELECT nama_lengkap, nim, program_studi FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$nama_lengkap = $user['nama_lengkap'];
$nim = $user['nim'];
$program_studi = $user['program_studi'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_kegiatan = $_POST['jenisKegiatan'];
    $semester = $_POST['semester'];
    $tanggal = $_POST['tanggal'];
    $point = $_POST['point'];
    $status = "Belum Selesai"; // Status default

    // Menangani upload file
    $lampiran_dokumen = $_FILES['lampiranDokumen']['name'];
    $upload_dir = "uploads/skkm/" . $nim . "/"; // Folder berdasarkan NIM
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Membuat folder jika belum ada
    }
    $upload_file = $upload_dir . basename($lampiran_dokumen);

    if (!empty($lampiran_dokumen)) {
        // Validasi file (hanya PDF dengan ukuran <= 2MB)
        $file_extension = strtolower(pathinfo($lampiran_dokumen, PATHINFO_EXTENSION));
        $file_size = $_FILES['lampiranDokumen']['size'];
        if ($file_extension != "pdf" || $file_size > 2 * 1024 * 1024) {
            die("File harus dalam format PDF dengan ukuran maksimal 2MB.");
        }

        // Pindahkan file ke folder uploads
        if (!move_uploaded_file($_FILES['lampiranDokumen']['tmp_name'], $upload_file)) {
            die("Gagal mengupload file.");
        }
    } else {
        $lampiran_dokumen = null; // Jika tidak ada file yang diupload
    }

    // Simpan data ke tabel SKKM
    $query = "INSERT INTO skkm (user_id, kegiatan, semester, tanggal, point, status) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssis", $user_id, $jenis_kegiatan, $semester, $tanggal, $point, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='ketSKKM.php';</script>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengumpulan SKKM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/FormStyle.css">
  <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

  <!-- Header Section -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.html">
          <span>Administrasi SKKM</span>
        </a>
      </nav>
      <a href="ketSKKM.php" class="btn-back">&lt; Back</a>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Form Pengumpulan SKKM</h5>
        <hr>
        <form id="skkmForm" method="POST" enctype="multipart/form-data">
          <!-- Nama Mahasiswa -->
          <div class="mb-3">
            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa" value="<?= htmlspecialchars($nama_lengkap); ?>" readonly>
          </div>

          <!-- NIM -->
          <div class="mb-3">
            <label for="nimMahasiswa" class="form-label">NIM <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nimMahasiswa" name="nimMahasiswa" value="<?= htmlspecialchars($nim); ?>" readonly>
          </div>

          <!-- Program Studi -->
          <div class="mb-3">
            <label for="programStudi" class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="programStudi" name="programStudi" value="<?= htmlspecialchars($program_studi); ?>" readonly>
          </div>

          <!-- Jenis Kegiatan -->
          <div class="mb-3">
            <label for="jenisKegiatan" class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="jenisKegiatan" name="jenisKegiatan" placeholder="Masukkan jenis kegiatan" required>
          </div>

          <!-- Semester -->
          <div class="mb-3">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="semester" name="semester" placeholder="Masukkan semester" required>
          </div>

          <!-- Tanggal -->
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
          </div>

          <!-- Point -->
          <div class="mb-3">
            <label for="point" class="form-label">Point <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="point" name="point" placeholder="Masukkan poin kegiatan" required>
          </div>

          <!-- Lampiran Dokumen -->
          <div class="mb-3">
            <label for="lampiranDokumen" class="form-label">Lampiran Dokumen</label>
            <input type="file" class="form-control" id="lampiranDokumen" name="lampiranDokumen">
            <small class="text-muted">Format file: PDF, maksimal 2 MB</small>
          </div>

          <!-- Tombol Submit -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
