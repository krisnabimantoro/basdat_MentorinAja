<?php
session_start();
include('connection.php'); 

$id_session = $_POST['id_session'];
$time_start = $_POST['time_start'];
$payment_method = $_POST['payment_method'];
$total_price = $_POST['total_price'];

$user_id = $_SESSION['user_id'];
$mentorship_id = $_SESSION['mentorship_id'];

try {
    $sql = "INSERT INTO ID_SESSION (ID_SESSION, TIME_START, TB_PAYMENT_ID_PAYMENT, TB_USER_ID_USER, TB_MENTORSHIP_ID_MENTORSHIP, TOTAL_PRICE) 
            VALUES (:id_session, TO_DATE(:time_start, 'YYYY-MM-DD HH24:MI:SS'), :payment_id, :user_id, :mentorship_id, :total_price)";
   
    switch ($payment_method) {
        case 'Dana':
            $payment_id = 2; 
            break;
        case 'Gopay':
            $payment_id = 1;
            break;
        case 'VA':
            $payment_id = 3; 
            break;
        default:
            $payment_id = 1; 
            break;
    }

    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':id_session', $id_session);
    oci_bind_by_name($stmt, ':time_start', $time_start);
    oci_bind_by_name($stmt, ':payment_id', $payment_id);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':mentorship_id', $mentorship_id);
    oci_bind_by_name($stmt, ':total_price', $total_price);

    $result = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if ($result) {
        oci_commit($conn); 
        echo "<script>alert('Data inserted successfully'); window.location.href='../pages/searching.php';</script>";
        exit();
    } else {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
