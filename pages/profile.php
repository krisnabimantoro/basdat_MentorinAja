<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

require '../php/connection.php';

$sql = 'SELECT * FROM tb_user where id_user = :user_id';
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':user_id', $user_id);
oci_execute($stid);
$user = oci_fetch_assoc($stid);

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MentorInAja - Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles//Profile.css" />
  </head>
</head>

<body>
<nav class="navbar">
    <div class="navbar-left">
      <img src="../icon/logo.png" alt="Logo" class="logo">
    </div>
    <div class="navbar-center">
      <ul class="menu">
        <?php if ($role == '2'): ?>
          <li><a href="#">Akun Mentor</a></li>
          <li><a href="./tambahmentor.html">Tambah Mentor</a></li>
          <li><a href="#">Pesanan</a></li>
        <?php elseif ($role == '1'): ?>
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

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic-wrapper">
                <img src="../img/Profile.png" alt="Profile Picture" class="profile-pic" id="currentProfilePic">
            </div>
            <div class="header-info">
                <h1 id="userName"><?php echo htmlspecialchars($user['NAME']); ?></h1>
            </div>
            <button class="view-profile">View Profile</button>
        </div>
        <div class="profile-settings">
            <div class="settings-header">
                <h2>Profile Settings</h2>
                <p>It allows you to showcase your contact information, making it easier for students or other users to reach out to you for mentoring opportunities.</p>
            </div>
            <div class="settings-section">
                <div class="section-description">
                    <h3>Public Profile</h3>
                    <p>This is will be deployed on your profile.</p>
                </div>
                <div class="profile-box">
                    <div class="form-group">
                        <div class="input-group">
                            <span>Name:</span>
                            <input type="text" id="public-name" placeholder="<?php echo htmlspecialchars($user['NAME']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span>mentorinaja.my.id/</span>
                            <input type="text" id="public-url" placeholder="Your URL">
                        </div>
                    </div>
                </div> <!-- closing profile-box -->
            </div> <!-- closing settings-section -->

            <div class="settings-section">
                <div class="section-description">
                    <h3>Social Profile</h3>
                    <p>You can link your Twitter and Instagram profiles to expand your reach and allow students or other users to interact with you on these platforms.</p>
                </div>
                <div class="profile-box">
                    <div class="form-group">
                        <div class="input-group">
                            <span>twitter.com/</span>
                            <input type="text" id="twitter" placeholder="Twitter username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span>instagram.com/</span>
                            <input type="text" id="instagram" placeholder="Instagram username">
                        </div>
                    </div>
                </div> <!-- closing profile-box -->
            </div> <!-- closing settings-section -->

            <div class="settings-section">
                <div class="section-description">
                    <h3>Profile Picture</h3>
                    <p>Update your profile picture.</p>
                </div>
                <div class="profile-box">
                    <div class="form-group">
                        <div class="upload-group">
                            <input type="file" id="profile-upload" accept=".svg, .png, .jpg, .jpeg, .gif" onchange="previewProfilePicture(event)">
                            <label for="profile-upload" style="cursor: pointer;">Click to upload or drag and drop SVG, PNG, JPG or GIF (800x400px)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <div class="section-description">
                    <h3>Account Profile</h3>
                    <p>It allows you to showcase your contact information, making it easier for students or other users to reach out to you for mentoring opportunities.</p>
                </div>
                <div class="profile-box">
                    <div class="form-group">
                        <div class="input-group">
                            <span>Email:</span>
                            <input type="email" id="email" placeholder="Your email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span>Phone Number:</span>
                            <input type="tel" id="phone" placeholder="Your phone number">
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button class="cancel">Cancel</button>
                <button class="save" onclick="saveChanges()">Save Changes</button>
            </div>
        </div> <!-- closing profile-settings -->
    </div> <!-- closing profile-container -->

    <script>
        function previewProfilePicture(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('currentProfilePic').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function saveChanges() {
            // Logic to save changes (placeholder)
            var newName = document.getElementById('public-name').value;
            document.getElementById('userName').textContent = newName;
            alert('Changes saved successfully!');
        }
    </script>
</body>

</html>
