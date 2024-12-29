<?php
  $today = date('Y-m-d');
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
  margin: 0;
  display: flex;
}

.content {
  margin-left: 270px;
  padding: 30px;
  width: 100%;
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

.logout-btn {
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

.logout-btn:hover {
  background-color: #a71d2a;
}

.table-container {
  margin-top: 20px;
}

.table {
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
  font-size: 14px;
  text-align: center; /* Ensures text is aligned at the center */
  vertical-align: middle; /* Ensures vertical alignment in the cells */
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

.status-completed {
  background-color: #4caf50;
  color: #2a9d8f;
  padding: 8px 16px;
  border-radius: 5px;
  font-weight: bold;
  text-align: center;
}

.status-rejected {
  background-color: #c34040;
  color: #c34040;
  padding: 8px 16px;
  border-radius: 5px;
  font-weight: bold;
  text-align: center;
}

.status-pending {
  background-color: #e63946;
  color: #e3a71c;
  padding: 8px 16px;
  border-radius: 5px;
  font-weight: bold;
  text-align: center;
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

.fine-input {
  border: 2px solid #ccc; /* Tambahkan border default */
  outline: none; /* Pastikan outline tidak muncul saat difokuskan */
  transition: border-color 0.3s ease; /* Efek transisi untuk border */
}

.fine-input:focus {
  border-color: #4caf50; /* Warna border saat difokuskan */
}

.fine-input[readonly] {
  background-color: #f2f2f2; /* Beri latar belakang abu-abu ketika readonly */
  border-color: #ddd; /* Warna border saat readonly */
}

  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Perpustakaan</h2>
    <ul>
      <li><a href="javascript:void(0)" onclick="showBooks()">Daftar Buku</a></li>
      <li><a href="javascript:void(0)" onclick="showAddBorrower()">Input Data Peminjam</a></li>
      <li><a href="javascript:void(0)" onclick="showBorrowingList()">List Peminjaman</a></li>
    </ul>
    <button class="logout-btn" onclick="logout()">Logout</button>
  </div>

  <section class="content" id="books-content">
    <h1>Daftar Buku</h1>
    <div class="mb-3">
      <input type="text" id="search" class="form-control" placeholder="Cari buku berdasarkan judul atau penulis..." onkeyup="searchBooks()">
    </div>
    <div class="table-container">
      <table class="table table-striped" id="books-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Status</th>
            <th>Tanggal Pinjam</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Dasar Pemrograman</td>
            <td>John Doe</td>
            <td class="text-success">Tersedia</td>
            <td>-</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Basis Data</td>
            <td>Jane Smith</td>
            <td class="text-danger">Dipinjam</td>
            <td>2024-12-01</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <section class="content" id="add-borrower-content" style="display: none;">
    <h1>Input Data Peminjam</h1>
    <div class="form-container">
      <form id="borrower-form" method="POST" action="save_borrower.php">
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Nama peminjam" required>
        </div>
        <div class="mb-3">
          <label for="nim" class="form-label">NIM</label>
          <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM peminjam" required>
        </div>
        <div class="mb-3">
          <label for="jurusan" class="form-label">Jurusan</label>
          <select class="form-select" id="jurusan" name="jurusan" required>
            <option value="">Pilih Jurusan</option>
            <option value="Teknik Mesin">Teknik Mesin</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
            <option value="Teknologi Informasi">Teknologi Informasi</option>
            <option value="Teknik Sipil">Teknik Sipil</option>
            <option value="Teknik Kimia">Teknik Kimia</option>
            <option value="Akuntansi">Akuntansi</option>
            <option value="Administrasi Niaga">Administrasi Niaga</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="prodi" class="form-label">Program Studi</label>
          <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Program Studi peminjam" required>
        </div>
        <div class="mb-3">
          <label for="book" class="form-label">Judul Buku</label>
          <input type="text" class="form-control" id="book" name="book" placeholder="Judul Buku yang Dipinjam" required>
        </div>
        <div class="mb-3">
          <label for="borrow-date" class="form-label">Tanggal Pinjam</label>
          <input type="date" class="form-control" id="borrow-date" name="borrow_date" value="<?php echo $today; ?>" required readonly>
        </div>
        <div class="mb-3">
          <label for="return-date" class="form-label">Tanggal Kembali</label>
          <input type="date" class="form-control" id="return-date" name="return_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </section>

  <section class="content" id="borrowing-list-content" style="display: none;">
    <h1>List Peminjaman</h1>
    <div class="mb-3">
      <input type="text" id="borrowing-search" class="form-control" placeholder="Cari berdasarkan Nama atau NIM..." onkeyup="searchBorrowingList()">
    </div>
    <div class="table-container">
      <table class="table table-striped" id="borrowing-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Prodi</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Denda</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Alice</td>
            <td>12345678</td>
            <td>Teknologi Informasi</td>
            <td>Teknik Informatika</td>
            <td>Basis Data</td>
            <td>2024-12-01</td>
            <td>2024-12-14</td>
            <td>
              <input type="text" class="form-control fine-input" placeholder="Rp 0" value="0">
            </td>
            <td>
              <button class="btn btn-verify" onclick="verifyReturn(this)">Verifikasi</button>
              <button class="btn btn-edit" onclick="editEntry(this)">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <script>
    function logout() {
      if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = "IndexAdmin.php";
      }
    }

    function showBooks() {
      document.getElementById('books-content').style.display = 'block';
      document.getElementById('add-borrower-content').style.display = 'none';
      document.getElementById('borrowing-list-content').style.display = 'none';
    }

    function showAddBorrower() {
      document.getElementById('books-content').style.display = 'none';
      document.getElementById('add-borrower-content').style.display = 'block';
      document.getElementById('borrowing-list-content').style.display = 'none';
    }

    function showBorrowingList() {
      document.getElementById('books-content').style.display = 'none';
      document.getElementById('add-borrower-content').style.display = 'none';
      document.getElementById('borrowing-list-content').style.display = 'block';
    }

    function searchBooks() {
      var filter = document.getElementById('search').value.toUpperCase();
      var rows = document.getElementById('books-table').getElementsByTagName('tr');
      for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var title = cells[1].textContent || cells[1].innerText;
        var author = cells[2].textContent || cells[2].innerText;
        if (title.toUpperCase().indexOf(filter) > -1 || author.toUpperCase().indexOf(filter) > -1) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    }

    function searchBorrowingList() {
      var filter = document.getElementById('borrowing-search').value.toUpperCase();
      var rows = document.getElementById('borrowing-table').getElementsByTagName('tr');
      for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var name = cells[1].textContent || cells[1].innerText;
        var nim = cells[2].textContent || cells[2].innerText;
        if (name.toUpperCase().indexOf(filter) > -1 || nim.toUpperCase().indexOf(filter) > -1) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    }

function verifyReturn(btn) {
  var row = btn.closest('tr');
  var fine = row.querySelector('.fine-input').value;
  
  // Verifikasi berhasil
  if (fine === "" || fine === "0") {
    alert("Pinjaman sudah selesai tanpa denda.");
  } else {
    alert("Denda: Rp " + fine);
  }

  // Sembunyikan tombol verifikasi dan tampilkan tombol edit
  btn.style.display = 'none'; // Sembunyikan tombol verifikasi
  var editButton = row.querySelector('.btn-edit');
  editButton.style.display = 'inline-block'; // Tampilkan tombol edit
  
  // Set input denda menjadi readonly setelah verifikasi
  var fineInput = row.querySelector('.fine-input');
  fineInput.setAttribute('readonly', 'readonly');
  
  // Pastikan border tetap ada setelah verifikasi
  fineInput.classList.add('readonly'); // Tambahkan kelas readonly
}

function editEntry(btn) {
  var row = btn.closest('tr');
  var fineInput = row.querySelector('.fine-input');
  
  // Hapus atribut readonly agar denda bisa diedit
  fineInput.removeAttribute('readonly');
  fineInput.focus();
  
  // Tampilkan tombol verifikasi dan sembunyikan tombol edit
  var verifyButton = row.querySelector('.btn-verify');
  verifyButton.style.display = 'inline-block'; // Tampilkan tombol verifikasi
  btn.style.display = 'none'; // Sembunyikan tombol edit
  
  // Pastikan border tetap terlihat setelah mengedit
  fineInput.classList.remove('readonly'); // Hapus kelas readonly
}

  </script>
</body>
</html>
