<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

require '../php/connection.php';

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
        <?php if ($role == '2'): ?>
          <li><a href="./editmentor.html">Akun Mentor</a></li>
          <li><a href="./tambahmentor.html">Tambah Mentor</a></li>
          <li><a href="#">Pesanan</a></li>
          <li><a href="./history.php">History</a></li>
          <?php elseif ($role == '1'): ?>
            <li><a href="#">Pemesanan</a></li>
            <li><a href="./history.php">History</a></li>
        
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
    <?php if ($row['AVAILABILITY'] === 'Yes'): ?>
        <div class="card" onclick="location.href='MentorshipDetail.php?id=<?php echo htmlspecialchars($row['ID_MENTORSHIP']); ?>'">
            <img class="gambar" src="../uploads/<?php echo htmlspecialchars($row['IMG']); ?>" alt="Mentorship Image" />
            <h3><?php echo htmlspecialchars($row['SPECIALIZATION']); ?></h3>
            <p><?php echo htmlspecialchars($row['DESCRIPTION']); ?></p>
            <div class="details">
                <p class="price">Rp. <?php echo number_format($row['PRICE'], 0, ',', '.'); ?></p>
                <p class="rating"><?php echo htmlspecialchars($row['RATE']); ?></p>
            </div>
        </div>
    <?php endif; ?>
<?php endwhile; ?>
    <?php
    oci_free_statement($stid);
    oci_close($conn);
    ?>

  </body>
</html>
