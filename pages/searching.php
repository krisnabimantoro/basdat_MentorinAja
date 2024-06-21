<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

require '../php/connection.php';

// Fetch mentorship data
$sql = 'SELECT * FROM tb_mentorship ';
$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MentorinAja/Searching</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/searching.css" />
  </head>
  <body>

  <nav class="navbar">
    <div class="navbar-left">
      <img src="../icon/logo.png" alt="Logo" class="logo">
    </div>
    <div class="navbar-center">
      <ul class="menu">
        <?php if ($role == '1'): ?>
          <li><a href="#">Akun Mentor</a></li>
          <li><a href="./tambahmentor.html">Tambah Mentor</a></li>
          <li><a href="#">Pesanan</a></li>
        <?php elseif ($role == '2'): ?>
          <li><a href="#">Pemesanan</a></li>
        <?php else: ?>
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Contact</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="navbar-right">
      <a href="./profile.php">

        <img src="../img/Profile.png" alt="Profile" class="profile-pic" >
      </a>
    </div>
  </nav>
    

    <div class="filters">
      <select>
        <option value="Bidang/pelajaran">Bidang/Pelajaran</option>
        <option value="Sains">Sains</option>
        <option value="Matematika">Matematika</option>
        <option value="Bahasa">Bahasa</option>
      </select>
      <select>
        <option value="Lokasi">Lokasi</option>
        <option value="Jakarta">Jakarta</option>
        <option value="Bandung">Bandung</option>
        <option value="Surabaya">Surabaya</option>
      </select>
      <select>
        <option value="Rekomendasi">Rekomendasi</option>
        <option value="Guru Populer">Guru Populer</option>
        <option value="Rating Tertinggi">Rating Tertinggi</option>
      </select>
      <select>
        <option value="Sort By">Sort By</option>
        <option value="Harga Tertinggi">Harga Tertinggi</option>
        <option value="Harga Terendah">Harga Terendah</option>
        <option value="Rating Tertinggi">Rating Tertinggi</option>
      </select>
    </div>

    
    <div class="mentorship-section">
      <h2>Mentorship</h2>
      <div class="mentorship-cards">
      <div class="cards-container">
    <?php while ($row = oci_fetch_assoc($stid)): ?>
      <div class="card">
      <img class="gambar" src="../uploads/<?php echo htmlspecialchars($row['IMG']); ?>" alt="Mentorship Image" />
        <h3><?php echo htmlspecialchars($row['SPECIALIZATION']); ?></h3>
        <p><?php echo htmlspecialchars($row['DESCRIPTION']); ?></p>
        <div class="details">
          <p class="price">Rp. <?php echo number_format($row['PRICE'], 0, ',', '.'); ?></p>
          <p class="rating"><?php echo htmlspecialchars($row['RATE']); ?></p>
        </div>
      </div>
    <?php endwhile; ?>
    <?php
    oci_free_statement($stid);
    oci_close($conn);
    ?>
  </div>


        <div class="card">
          <img src="../img/Science.png" alt="Science" />
          <h3>Muhammad Arif Irfan</h3>
          <p>Salam! Saya Muhammad Arif Irfan, siap membantu Anda mencapai potensi terbaik...</p>
          <div class="details">
            <p class="price">Rp. 20.000</p>
            <p class="rating">4.9</p>
          </div>
        </div>
        <div class="card">
          <img src="../img/Math.png" alt="Geography" />
          <h3>Rofiq Samahudi</h3>
          <p>Assalamualaikum Wr. Wb. Mari belajar bersama menuju kehidupan...</p>
          <div class="details">
            <p class="price">Rp. 20.000</p>
            <p class="rating">Rate</p>
          </div>
        </div>
        <div class="card">
          <img src="../img/Science.png" alt="Math" />
          <h3>Ridwan Kamil</h3>
          <p>Tingkatkan keterampilan dalam menguasai ilmu dunia. Matematika hadir memberikan...</p>
          <div class="details">
            <p class="price">Rp. 20.000</p>
            <p class="rating">Rate</p>
          </div>
        </div>
        <div class="card">
          <img src="../img/Science.png" alt="Tambahan" />
          <h3>Example</h3>
          <p>Contoh</p>
          <div class="details">
            <p class="price">Rp.</p>
            <p class="rating">Rate</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
