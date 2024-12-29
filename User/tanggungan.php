<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <title>JTI Dependents Dashboard</title>
  <link rel="shortcut icon" href="images/favicon.png" type="">
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <style>

    body {
  background-color: #f4f4f4;
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.dashboard-section {
  padding: 40px 0;
}

.dashboard-container {
  display: flex;
  flex-wrap: wrap; /* Izinkan elemen berpindah ke baris baru */
  justify-content: center; /* Pusatkan kartu di setiap baris */
  gap: 30px; /* Jarak antar elemen horizontal dan vertikal */
  max-width: 1000px; /* Batasi lebar kontainer */
  margin: auto; /* Pusatkan kontainer */
}

.dashboard-card {
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: calc(33.33% - 20px); /* Lebar kartu 1/3 dari kontainer */
  height: 400px; /* Tinggi tetap */
  display: flex;
  flex-direction: column; /* Elemen diatur vertikal */
  align-items: center; /* Elemen di dalam kartu rata tengah */
  justify-content: space-between; /* Jarak antar elemen diatur */
  padding: 20px;
  text-align: center;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.dashboard-card:hover {
  transform: translateY(-10px); /* Animasi hover naik */
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Bayangan lebih dalam saat hover */
}

.dashboard-card img {
  width: 120px;
  height: 120px;
  margin-bottom: 15px;
}

.dashboard-card h5 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 10px;
  color: #333;
}

.dashboard-card p {
  font-size: 14px;
  color: #666;
  margin-bottom: 15px;
}

.dashboard-card a {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s ease;
}

.dashboard-card a:hover {
  background-color: #0056b3;
}


  </style>
</head>

<body class="sub_page">
  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="">
      </div>
    </div>

    <!-- Header Section -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>JTI DEPENDENTS</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Beranda</a>
              </li>             
              <li class="nav-item active">
                <a class="nav-link" href="tanggungan.php">Tangunggan<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="helpdesk.html">Status</a>
              </li>   
            </ul>
          </div>
          <a href="logout.php" class="btn-logout">Keluar</a>
        </nav>
      </div>
    </header>
    <!-- End Header Section -->
  </div>

  <!-- Dashboard Section -->
  <section class="dashboard-section">
    <div class="container">
      <div class="dashboard-container">
        <div class="dashboard-card">
          <img src="images/Laporan Bebas Tanggungan.png" alt="Laporan Tugas Akhir">
          <h5>Laporan Tugas Akhir</h5>
          <p>Kelola segala tunggakan akademik seperti laporan Tugas Akhir sebelum melakukan wisuda</p>
          <a href="KetTA.php">Selengkapnya</a>
        </div>
        <div class="dashboard-card">
          <img src="images/Surat Kompensasi.png" alt="Surat Kompensasi">
          <h5>Surat Bebas Kompensasi</h5>
          <p>Lengkapi proses administrasi untuk Kompensasi sebagai pengganti absensi mahasiswa dalam proses perkuliahan.</p>
          <a href="KetKompen.php">Selengkapnya</a>
        </div>
        <div class="dashboard-card">
          <img src="images/Bayar UKT.png" alt="Surat Bebas Pembayaran">
          <h5>Biaya Akademik</h5>
          <p>Penuhi Biaya kuliah dan administrasi langsung dari dashboard Anda.</p>
          <a href="ketBA.php">Selengkapnya</a>
        </div>
        <div class="dashboard-card">
          <img src="images/bebas peminjaman.png" alt="TOEIC">
          <h5>Surat Bebas Peminjaman</h5>
          <p>Lengkapi Surat Bebas peminjaman buku Perpustakaan</p>
          <a href="ketBP.php">Selengkapnya</a>
        </div>
        <div class="dashboard-card">
          <img src="images/SKKM.png" alt="SKKM">
          <h5>SKKM</h5>
          <p>Lengkapi capaian angka kredit kegiatan yang diperoleh mahasiswa Polinema selama mengikuti pendidikan.</p>
          <a href="ketSKKM.php">Selengkapnya</a>
        </div>
        <div class="dashboard-card">
          <img src="images/TOEIC.png" alt="TOEIC">
          <h5>TOEIC</h5>
          <p>TOEIC® diperuntukkan untuk mahasiswa tingkat akhir sebagi alat ukur kemampuan bahasa Inggris.</p>
          <a href="ketTOEIC.php">Selengkapnya</a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Dashboard Section -->


  <!-- jQery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>