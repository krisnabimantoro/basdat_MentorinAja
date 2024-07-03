<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Pembayaran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/History.css">
</head>
<body>
    <div class="container">
        <a href="./searching.php">
            <button class="back-button"><i class="fas fa-arrow-left"></i> Kembali</button>
        </a>
        <h1>History Pembayaran</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Nama Mentor</th>
                        <th>Jenis Mentor Spesifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../php/connection.php');

                    $sql = "
                        SELECT
                            s.TIME_START,
                            s.TOTAL_PRICE,
                            p.METHOD,
                            u.NAME,
                            m.SPECIALIZATION
                        FROM
                            TB_SESSION s
                        JOIN
                            TB_PAYMENT p ON s.TB_PAYMENT_ID_PAYMENT = p.ID_PAYMENT
                        JOIN
                            TB_USER u ON s.TB_USER_ID_USER = u.ID_USER
                        JOIN
                            TB_MENTORSHIP m ON s.TB_MENTORSHIP_ID_MENTORSHIP = m.ID_MENTORSHIP
                        ORDER BY
                            s.TIME_START DESC";

                    $stmt = oci_parse($conn, $sql);
                    oci_execute($stmt);

                    while ($row = oci_fetch_assoc($stmt)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['TIME_START']) . "</td>";
                        echo "<td>Rp. " . number_format($row['TOTAL_PRICE'], 0, ',', '.') . "</td>";
                        echo "<td>" . htmlspecialchars($row['METHOD']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['NAME']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['SPECIALIZATION']) . "</td>";
                        echo "</tr>";
                    }

                    oci_free_statement($stmt);
                    oci_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
