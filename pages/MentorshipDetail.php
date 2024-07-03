<?php
session_start();
include('../php/connection.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql = "
        SELECT 
            tm.ID_MENTORSHIP,
            tm.SPECIALIZATION,
            tm.AVAILABILITY,
            tm.RATE,
            tm.DESCRIPTION,
            tm.PRICE,
            tm.TB_STATUS_ID_STATUS AS STATUS,
            tm.TB_USER_ID_USER,
            tm.IMG,
            u.NAME AS MENTOR_NAME,
            u.ADDRESS AS LOCATION,
            u.IMG_PROFILE AS PROFILE_PIC,
            u.NO_HANDPHONE
        FROM 
            tb_mentorship tm
        JOIN 
            tb_user u ON tm.TB_USER_ID_USER = u.ID_USER
        WHERE 
            tm.ID_MENTORSHIP = :id
            AND u.TB_ROLE_ID_ROLE = 2";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $whatsappUrl = "https://wa.me/" . htmlspecialchars($row['NO_HANDPHONE']);
        $_SESSION['user_id'] = $row['TB_USER_ID_USER'];
        $_SESSION['mentorship_id'] = $id;
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mentorship Detail</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;600&family=Montserrat:wght@300;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../styles/MentorshipDetail.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        </head>
        <body>
            <div class="container">
                <header class="header">
                    <div class="profile-pic">
                        <img src="../uploads/<?php echo htmlspecialchars($row['PROFILE_PIC']); ?>" alt="Profile Picture of <?php echo htmlspecialchars($row['MENTOR_NAME']); ?>">
                    </div>
                    <div class="mentor-info">
                        <h1><?php echo htmlspecialchars($row['MENTOR_NAME']); ?></h1>
                        <div class="location">
                            <span class="icon">📍</span>
                            <p><?php echo htmlspecialchars($row['LOCATION']); ?></p>
                        </div>
                        <div class="mentorship">Mentorship</div>
                    </div>
                </header>

                <main class="main-content">
                    <h2><?php echo htmlspecialchars($row['SPECIALIZATION']); ?></h2>
                    <div class="subject-image">
                        <img src="../uploads/<?php echo htmlspecialchars($row['IMG']); ?>" alt="<?php echo htmlspecialchars($row['SPECIALIZATION']); ?>">
                    </div>
                    <p class="description">
                        <?php echo htmlspecialchars($row['DESCRIPTION']); ?>
                    </p>
                </main>

                <section class="mentorship-detail">
                    <div class="ketersediaan-group">
                        <div class="ketersediaan">Ketersediaan</div>
                        <div class="tersedia"><?php echo htmlspecialchars($row['AVAILABILITY']) === 'Yes' ? 'Tersedia' : 'Tidak Tersedia'; ?></div>
                    </div>
                    <div class="lokasi-group">
                        <div class="lokasi">Lokasi</div>
                        <div class="alamat"><?php echo htmlspecialchars($row['LOCATION']); ?></div>
                    </div>
                    <div class="metode-belajar-group">
                        <div class="metode-belajar">Metode Belajar</div>
                        <div class="offline"><?php echo htmlspecialchars($row['STATUS']) === '2' ? 'Offline' : 'Online'; ?></div>
                    </div>

                    <div class="button-group">
                        <form id="paymentForm" action="" method="post">
                            <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($row['PRICE']); ?>">
                            <select name="payment_method">
                                <option value=2>Dana</option>
                                <option value=1>Gopay</option>
                                <option value=3>VA</option>
                            </select>
                            <button type="submit" class="price-button">Rp. <?php echo number_format($row['PRICE'], 0, ',', '.'); ?></button>
                        </form>
                        <div class="whatsapp">
                            <a href="<?php echo $whatsappUrl; ?>" target="_blank">
                                <button class="whatsapp-button">Whatsapp</button>
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <script>
            $(document).ready(function() {
                $('#paymentForm').submit(function(e) {
                    e.preventDefault(); // Prevent form submission

                    var formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        type: 'POST',
                        url: '../php/save_session.php', // PHP script to handle data insertion
                        data: formData,
                        success: function(response) {
                            alert(response); // Show success or error message
                            // Optionally, redirect or perform additional actions
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('Failed to save session data.');
                        }
                    });
                });
            });
            </script>
        </body>
        </html>

        <?php
    } else {
        echo "<p>No mentorship details found.</p>";
    }

    oci_free_statement($stmt);
    oci_close($conn);
} else {
    echo "<p>No mentorship ID provided.</p>";
}
?>
