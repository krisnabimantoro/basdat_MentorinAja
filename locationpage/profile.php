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
    <link rel="stylesheet" href="../styles/Profile.css">
    <link rel="stylesheet" href="../styles/profile2.css">
    
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic-wrapper">
                <img src="../uploads/<?php echo htmlspecialchars($row['IMG']); ?>" alt="Profile Picture" class="profile-pic" id="currentProfilePic">
            </div>
            <div class="header-info">
                <h1><?php echo htmlspecialchars($user['NAME']); ?></h1>
                <button class="view-profile">View Profile</button>
            </div>
        </div>
        <div class="profile-settings">
            <div class="settings-header">
                <h2>Profile Settings</h2>
                <p>Profile settings allow you to manage your preferences and personal information.</p>
            </div>
            <div class="settings-section">
                <div class="section-description">
                    <h3>Public Profile</h3>
                    <p>This will be displayed on your profile.</p>
                </div>
                <div class="public-profile-box">
                    <div class="form-group">
                        <label for="public-profile">Public Profile</label>
                        <div class="input-group">
                            <input type="text" id="public-profile" placeholder="<?php echo htmlspecialchars($user['NAME']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="public-url">Public URL</label>
                        <div class="input-group">
                            <input type="text" id="public-url" value="mentorinaja.my.id/rofiqsamanhudi">
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings-section">
                <div class="section-description">
                    <h3>Social Profile</h3>
                    <p>You can link your Twitter and Instagram profiles to expand your reach and allow students or other users to interact with you on these platforms.</p>
                </div>
                <div class="social-profile-box">
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <div class="input-group">
                            <input type="text" id="twitter" value="twitter.com/RofiqSamanhudiii">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <div class="input-group">
                            <input type="text" id="instagram" value="instagram.com/@rofiqsamanhudi_">
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings-section">
                <div class="section-description">
                    <h3>Profile Picture</h3>
                    <p>Update your profile picture</p>
                </div>
                <div class="profile-picture-upload">
                    <div class="upload-box">
                        <div class="upload-info">
                            <input type="file" id="upload-input" accept="image/*" onchange="previewImage(this)">
                            <label for="upload-input" class="upload-label">Click to upload or drag and drop SVG, PNG, JPG or GIF (800x400px)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings-section">
                <div class="section-description">
                    <h3>Account Profile</h3>
                    <p>This is your personal information.</p>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="email" id="email" value="rofiqsamanhudi@gmail.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <div class="input-group">
                        <input type="tel" id="phone" value="+62 878 5397 4474">
                    </div>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <div class="input-group">
                        <input type="text" id="location" value="Jawa Timur">
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button class="cancel">Cancel</button>
                <button class="save">Save</button>
            </div>
        </div>
    </div>
    <script src="../php/profile.php"></script>
    <script>
        function previewImage(input) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('currentProfilePic').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>