<?php
session_start();  // Mulai session untuk menyimpan data pengguna

// Menyertakan koneksi ke database
include 'koneksi.php';  // Pastikan file koneksi.php sudah benar

$errorMessage = ''; // Untuk menyimpan pesan error jika login gagal

// Proses login ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nim']) && isset($_POST['password'])) {
        $nim = $_POST['nim'];
        $password = $_POST['password'];

        // Query untuk memeriksa apakah cocok
        $sql = "SELECT * FROM users WHERE nim = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nim);  // Binding NIM
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek jika NIM ditemukan
        if ($result->num_rows > 0) {
            // Ambil data pengguna dari database
            $user = $result->fetch_assoc();
            
            // Verifikasi password jika cocok
            if ($password === $user['password']) {
                // Set session dengan user_id dan nim
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['nim'] = $user['nim'];  // Bisa menyimpan NIM jika dibutuhkan

                // Jika password cocok, login berhasil, redirect ke index.php
                header("Location: index.php");  // Redirect ke halaman setelah login berhasil
                exit;  // Hentikan eksekusi script lebih lanjut setelah redirect
            } else {
                // Jika password tidak cocok
                $errorMessage = 'NIM atau Password salah!';
            }
        } else {
            // Jika NIM tidak ditemukan
            $errorMessage = 'NIM atau Password salah!';
        }

        $stmt->close();
    } else {
        $errorMessage = 'NIM atau Password tidak dikirimkan dengan benar!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>JTI DEPENDENTS</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/responsive.css"> <!-- Responsive Styles -->
</head>
<body>
  <!-- Section: Sign Form -->
  <header class="header_section">
    <div class="container-fluid p-0">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="#">
          <span>JTI DEPENDENTS</span>
        </a>
      </nav>
    </div>
  </header>

  <section class="background-radial-gradient overflow-hidden">
    <div class="container px-4 py-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <!-- Form Section -->
        <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
          <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
            <img src="images/login.jpeg" alt="Logo" class="navbar-logo">
            SISTEM <br />
            <span style="color: hsl(218, 81%, 75%)">TANGGUNGAN</span>
          </h1>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
          <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
          <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

          <div class="card bg-glass">
            <div class="card-body px-4 py-5 px-md-5">
              <!-- Form Login -->
              <form method="POST">
                <div class="mb-4">
                  <h5>Masukkan NIM dan Password Anda</h5>
                </div>

                <!-- NIM input -->
                <div class="form-outline mb-4">
                  <input type="text" name="nim" id="nim" class="form-control" required />
                  <label class="form-label" for="nim">NIM</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="password" class="form-control" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                  <label class="form-check-label" for="form2Example33">
                    Simpan Riwayat Login
                  </label>
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary btn-block mb-4">
                    Login
                  </button>
                </div>
              </form>

              <!-- Menampilkan pesan error jika login gagal -->
              <?php if ($errorMessage): ?>
                <div id="errorAlert" style="display: block; color: red; text-align: center;">
                  <?php echo $errorMessage; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
