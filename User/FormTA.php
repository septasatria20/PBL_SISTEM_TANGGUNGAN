<?php
// Memulai sesi
session_start();

// Mengambil user_id dari sesi (misalnya setelah login)
$user_id = $_SESSION['user_id']; // pastikan user_id ada di session setelah login

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
    $nama_mahasiswa = $_POST['namaMahasiswa'];
    $nim_mahasiswa = $_POST['nimMahasiswa'];
    $program_studi = $_POST['programStudi'];
    $judul_tugas_akhir = $_POST['judulTugasAkhir'];
    $abstrak = $_POST['abstrak'];
    $lampiran_dokumen = $_FILES['lampiranDokumen']['name']; // bagian untuk menangani file upload

    // Menangani upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["lampiranDokumen"]["name"]);
    move_uploaded_file($_FILES["lampiranDokumen"]["tmp_name"], $target_file);

    // Menyimpan data ke tabel tugas_akhir
    $query = "INSERT INTO tugas_akhir (nama_mahasiswa, nim_mahasiswa, program_studi, judul_tugas_akhir, abstrak, lampiran_dokumen, user_id) 
              VALUES ('$nama_mahasiswa', '$nim_mahasiswa', '$program_studi', '$judul_tugas_akhir', '$abstrak', '$lampiran_dokumen', '$user_id')";
    
    if (mysqli_query($conn, $query)) {
        echo "Data berhasil disubmit!";
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
  <title>Pengumpulan Tugas Akhir</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/FormStyle.css"> <!-- Custom Styles -->
  <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

  <!-- Bagian Header -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.php">
          <span>Administrasi Tugas Akhir</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Tombol Back di pojok kanan atas -->
        </div>        
      </nav>
      <!-- Tombol Back -->
      <a href="KetTA.php" class="btn-back">&lt; Kembali</a>
    </div>
  </header>

  <!-- Konten Utama -->
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Form Pengumpulan Tugas Akhir</h5>
        <hr>
        <form id="taskForm" method="POST" enctype="multipart/form-data">
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

          <!-- Judul Tugas Akhir -->
          <div class="mb-3">
            <label for="judulTugasAkhir" class="form-label">Judul Tugas Akhir <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="judulTugasAkhir" name="judulTugasAkhir" placeholder="Masukkan Judul Tugas Akhir" required>
          </div>

          <!-- Abstrak -->
          <div class="mb-3">
            <label for="abstrak" class="form-label">Abstrak <span class="text-danger">*</span></label>
            <textarea class="form-control" id="abstrak" name="abstrak" rows="3" placeholder="Masukkan abstrak tugas akhir..." required></textarea>
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
