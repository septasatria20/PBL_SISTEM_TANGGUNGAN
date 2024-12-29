<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Tanggungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Open Sans", sans-serif;
      color: #333;
      background-color: #f9f9f9;
      margin: 0;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #231a6f;
      color: #fff;
      min-height: 100vh;
      padding: 20px;
      position: fixed;
    }

    .sidebar h2 {
      font-size: 22px;
      margin-bottom: 20px;
      text-align: center;
      font-weight: bold;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 10px 0;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      display: block;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .sidebar ul li a:hover {
      background-color: #374085;
    }

    .sidebar .logout-btn {
      margin-top: 20px;
      display: block;
      width: 100%;
      background-color: #dc3545;
      border: none;
      color: #fff;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .sidebar .logout-btn:hover {
      background-color: #a71d2a;
    }

    .content {
      margin-left: 270px;
      padding: 30px;
      width: 100%;
    }

    .dashboard-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .dashboard-card {
      flex: 1 1 calc(33.333% - 20px);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      min-height: 300px;
    }

    .dashboard-card img {
      max-width: 100px;
      height: auto;
      border-radius: 10px;
    }

    .dashboard-card h5 {
      font-size: 18px;
      margin-top: 15px;
      font-weight: bold;
    }

    .dashboard-card p {
      font-size: 16px;
      flex-grow: 1;
      margin: 10px 0;
    }

    .dashboard-card .progress-bar {
      width: 100%;
      height: 20px;
      background-color: #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
      margin-top: 15px;
    }
    

    .dashboard-card a {
      display: inline-block;
      margin-top: 20px;
      font-weight: bold;
      color: #231a6f;
      text-decoration: none;
      background: #e8e8e8;
      padding: 5px 15px;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .dashboard-card a:hover {
      background: #d6d6d6;
    }

    .progress-bar .progress {
      height: 100%;
      border-radius: 10px;
      background: linear-gradient(to right, #4caf50, #8bc34a);
      position: absolute;
      top: 0;
      left: 0;
      transition: width 0.5s ease-in-out;
    }

    .progress-bar .progress.animate {
      animation: load 2s ease-in-out forwards;
    }

    .progress-bar .progress-percentage {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 14px;
      font-weight: bold;
      color: #fff;
    }

    @keyframes load {
      0% {
        width: 0%;
      }
      100% {
        width: var(--progress-width);
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
      <li><a href="javascript:void(0)" onclick="showHome()">Beranda</a></li>
    </ul>
    <button class="logout-btn" onclick="logout()">Keluar</button>
  </div>

  <!-- Beranda Content -->
  <section class="content" id="home-content">
    <div class="container">
      <div class="dashboard-container">
        <div class="dashboard-card">
          <img src="images/Laporan Bebas Tanggungan.png" alt="Laporan Tugas Akhir">
          <h5>Laporan Tugas Akhir</h5>
          <p>Kelola segala tunggakan akademik seperti laporan Tugas Akhir sebelum melakukan wisuda</p>
          <div class="progress-bar">
            <div class="progress" style="--progress-width: 50%; width: 50%;">
              <div class="progress-percentage">50%</div>
            </div>
          </div>
          <a href="KetTA.php">Masuk</a>
        </div>
        <div class="dashboard-card">
          <img src="images/Surat Kompensasi.png" alt="Surat Kompensasi">
          <h5>Surat Bebas Kompensasi</h5>
          <p>Lengkapi proses administrasi untuk Kompensasi sebagai pengganti absensi mahasiswa dalam proses perkuliahan.</p>
          <div class="progress-bar">
            <div class="progress" style="--progress-width: 83%; width: 83%;">
              <div class="progress-percentage">83%</div>
            </div>
          </div>
          <a href="KetKompen.php">Masuk</a>
        </div>
        <div class="dashboard-card">
          <img src="images/Bayar UKT.png" alt="Surat Bebas Pembayaran">
          <h5>Biaya Akademik</h5>
          <p>Penuhi Biaya kuliah dan administrasi langsung dari dashboard Anda.</p>
          <div class="progress-bar">
            <div class="progress" style="--progress-width: 65%; width: 65%;">
              <div class="progress-percentage">65%</div>
            </div>
          </div>
          <a href="ketBA.php">Masuk</a>
        </div>
        <div class="dashboard-card">
          <img src="images/SKKM.png" alt="SKKM">
          <h5>SKKM</h5>
          <p>Lengkapi capaian angka kredit kegiatan yang diperoleh mahasiswa Polinema selama mengikuti pendidikan.</p>
          <div class="progress-bar">
            <div class="progress" style="--progress-width: 64%; width: 64%;">
              <div class="progress-percentage">64%</div>
            </div>
          </div>
          <a href="ketSKKM.php">Masuk</a>
        </div>
        <div class="dashboard-card">
          <img src="images/TOEIC.png" alt="TOEIC">
          <h5>TOEIC</h5>
          <p>TOEIC® diperuntukkan untuk mahasiswa tingkat akhir sebagi alat ukur kemampuan bahasa Inggris.</p>
          <div class="progress-bar">
            <div class="progress" style="--progress-width: 87%; width: 87%;">
              <div class="progress-percentage">87%</div>
            </div>
          </div>
          <a href="ketTOEIC.php">Masuk</a>
        </div>
      </div>
    </div>
  </section>

  <script>
    function logout() {
      if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = "IndexAdmin.php";
      }
    }

    function showHome() {
      document.getElementById('home-content').style.display = 'block';
      document.getElementById('profile-content').style.display = 'none';
    }

    function toggleProfileMenu() {
      const menu = document.getElementById('profile-menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function showLevel(level) {
      document.getElementById('home-content').style.display = 'none';
      document.getElementById('profile-content').style.display = 'block';
    }
  </script>

</body>
</html>
