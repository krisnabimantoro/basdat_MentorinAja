<?php
session_start();
include('../php/connection.php');

// Cek apakah mentorship_id sudah diset di sesi

$id = isset($_GET['id']) ? $_GET['id'] : null;


$mentorship_id = $id;

try {
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
    oci_bind_by_name($stmt, ':id', $mentorship_id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $whatsappUrl = "https://wa.me/" . htmlspecialchars($row['NO_HANDPHONE']);
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Pembayaran Paket Langganan</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-bTf4spSSdUsaZebwGF6JyQ/rQwB1L+cO8yXeFoM0+nmySisC4j0CzWnYBMl0X8G66hGjXJyYKl4M8m4t3aI0KQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="../styles/pembayaran.css">
        </head>
        <body>
            <div class="container">
                <button class="back-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                <h1>Pembayaran untuk Paket Langganan</h1>
                <div class="payment-info">
                    <div class="package-info">
                        <h2>Harga Langganan</h2>
                        <p>1 bulan (30 hari)</p>
                        <p class="price">Rp. <?php echo number_format($row['PRICE'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="promo-code">
                        <h2>Kode Promo <i class="fas fa-info-circle"></i></h2>
                        <p>Silahkan pilih metode pembayaran Anda!</p>
                        <select class="promo-button">
                            <option value="Dana">Dana</option>
                            <option value="Gopay">Gopay</option>
                            <option value="VA">VA</option>
                        </select>
                    </div>
                    <div class="total-amount">
                        <h2>Jumlah Tagihan</h2>
                        <p class="total">Rp. <?php echo number_format($row['PRICE'], 0, ',', '.'); ?></p>
                        <button class="pay-button">Bayar</button>
                    </div>
                </div>
            </div>
        </body>
        </html>

        <?php
    } 

    oci_free_statement($stmt);
    oci_close($conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
