<!DOCTYPE html>
<html lang="en">
<head>
  <title>JTI DEPENDENTS</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/responsive.css">
  <style>
    /* Custom Style for the eye icon button */
    #togglePasswordButton {
      background-color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
    }
    #togglePasswordButton:hover {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header class="header_section">
    <div class="container-fluid p-0">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="#">
          <span>JTI DEPENDENTS</span>
        </a>
      </nav>
    </div>
  </header>

  <!-- Main Section -->
  <section class="background-radial-gradient overflow-hidden">
    <div class="container px-4 py-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <!-- Form Section -->
        <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
          <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
            <img src="images/login.jpeg" alt="Logo" class="navbar-logo">
            ADMIN <br />
            <span style="color: hsl(218, 81%, 75%)">SISTEM TANGGUNGAN</span>
          </h1>
        </div>

        <!-- Login Form -->
        <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
          <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
          <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

          <div class="card bg-glass">
            <div class="card-body px-4 py-5 px-md-5">
              <form method="POST" action="">
                <!-- Role Selection -->
                <div class="mb-3">
                  <label for="role" class="form-label">Pilih Role</label>
                  <select id="role" name="role" class="form-select" required>
                    <option value="akademik">Admin Akademik</option>
                    <option value="perpustakaan">Admin Perpustakaan</option>
                  </select>
                </div>

                <div class="mb-4">
                  <h5>Masukkan Username dan Password Anda</h5>
                </div>

                <!-- Username Input -->
                <div class="form-outline mb-4">
                  <input type="text" id="username" name="username" class="form-control" required />
                  <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password Input -->
                <div class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" checked />
                  <label class="form-check-label" for="remember">
                    Simpan Riwayat Login
                  </label>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>
                </div>
              </form>

              <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                  $users = [
                    ["username" => "JTIADMIN", "password" => "admin123", "role" => "akademik"],
                    ["username" => "PERPUSADMIN", "password" => "perpus123", "role" => "perpustakaan"],
                  ];

                  $username = trim($_POST['username']);
                  $password = trim($_POST['password']);
                  $role = $_POST['role'];

                  if (empty($username) || empty($password) || empty($role)) {
                    echo "<div class='alert alert-danger'>Semua bidang harus diisi!</div>";
                  } else {
                    $user = array_filter($users, function($u) use ($username, $role) {
                      return $u['username'] === $username && $u['role'] === $role;
                    });

                    if ($user && current($user)['password'] === $password) {
                      echo "<div class='alert alert-success'>Login berhasil sebagai $role!</div>";
                      if ($role === "akademik") {
                        echo "<script>window.location.href='AdminAkademik.php';</script>";
                      } else {
                        echo "<script>window.location.href='AdminPerpus.php';</script>";
                      }
                    } else if (array_filter($users, function($u) use ($username) {
                      return $u['username'] === $username;
                    })) {
                      echo "<div class='alert alert-danger'>Username sudah digunakan pada role lain!</div>";
                    } else {
                      echo "<div class='alert alert-danger'>Login gagal! Periksa username, password, atau role.</div>";
                    }
                  }
                }
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
