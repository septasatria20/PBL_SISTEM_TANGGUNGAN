<?php
// Memulai sesi
session_start();

// Mengambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Menyertakan koneksi database
include('koneksi.php');

// Mengambil data pengguna berdasarkan user_id
$query_user = "SELECT nama_lengkap, nim, program_studi FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$nama_lengkap = $user['nama_lengkap'];
$nim = $user['nim'];
$program_studi = $user['program_studi'];

// Menangani pengiriman form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data form
    $semester = $_POST['semester'];
    $tanggal = $_POST['tanggal'];
    $pekerjaan = $_POST['pekerjaan'];
    $durasi_kompensasi = $_POST['durasiKompensasi'];
    $lampiran_dokumen = $_FILES['lampiranDokumen']['name'];

    // Menangani upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["lampiranDokumen"]["name"]);
    move_uploaded_file($_FILES["lampiranDokumen"]["tmp_name"], $target_file);

    // Menyimpan data ke tabel kompen
    $query = "INSERT INTO kompen (user_id, semester, tanggal, pekerjaan, durasi_kompensasi, status, file_path) 
    VALUES ('$user_id', '$semester', '$tanggal', '$pekerjaan', '$durasi_kompensasi', 'Sedang Diproses', '$lampiran_dokumen')";


    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil disubmit!'); window.location.href='ketkompen.php';</script>";
    } else {
        echo "Terjadi kesalahan: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Kompensasi</title>
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
        <a class="navbar-brand" href="index.php">
          <span>Administrasi Kompensasi</span>
        </a>
      </nav>
      <a href="ketkompen.php" class="btn-back">&lt; Kembali</a>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Form Kompensasi</h5>
        <hr>
        <form id="compensationForm" method="POST" enctype="multipart/form-data">
          <!-- Nama Mahasiswa -->
          <div class="mb-3">
            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa" value="<?php echo htmlspecialchars($nama_lengkap); ?>" readonly>
          </div>

          <!-- NIM -->
          <div class="mb-3">
            <label for="nimMahasiswa" class="form-label">NIM <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nimMahasiswa" name="nimMahasiswa" value="<?php echo htmlspecialchars($nim); ?>" readonly>
          </div>

          <!-- Program Studi -->
          <div class="mb-3">
            <label for="programStudi" class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="programStudi" name="programStudi" value="<?php echo htmlspecialchars($program_studi); ?>" readonly>
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

          <!-- Pekerjaan -->
          <div class="mb-3">
            <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Masukkan pekerjaan" required>
          </div>

          <!-- Durasi Kompensasi -->
          <div class="mb-3">
            <label for="durasiKompensasi" class="form-label">Durasi Kompensasi (jam) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="durasiKompensasi" name="durasiKompensasi" placeholder="Masukkan durasi kompensasi" required>
          </div>

          <!-- Lampiran Dokumen -->
          <div class="mb-3">
            <label for="lampiranDokumen" class="form-label">Lampiran Dokumen</label>
            <input type="file" class="form-control" id="lampiranDokumen" name="lampiranDokumen">
            <small class="form-text text-muted">Dokumen harus dalam format PDF.</small>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
