<?php
session_start();
include('../php/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['mentorship_id'])) {
    // Validate and sanitize input (if needed)
    $mentorship_id = $_SESSION['mentorship_id'];
    $user_id = $_SESSION['user_id']; // Assuming this is set in a previous step

    // Assuming you get payment details from form submission
    $total_price = $_POST['total_price']; // Make sure to sanitize and validate input
    $payment_method = $_POST['payment_method']; // Assuming you have a payment method selected

    try {
        // Insert into TB_SESSION table
        $sql_insert_session = "
            INSERT INTO TB_SESSION (ID_SESSION, TIME_START, TB_PAYMENT_ID_PAYMENT, TB_USER_ID_USER, TB_MENTORSHIP_ID_MENTORSHIP, TOTAL_PRICE)
            VALUES (:id_session, SYSDATE, :payment_id, :user_id, :mentorship_id, :total_price)
        ";

        $stmt_insert_session = oci_parse($conn, $sql_insert_session);

        // Generate ID_SESSION (you may use a function or library to generate a unique ID)
        $id_session = uniqid('session_', true); // Example of generating a unique ID

        oci_bind_by_name($stmt_insert_session, ':id_session', $id_session);
        oci_bind_by_name($stmt_insert_session, ':payment_id', $payment_method); // Assuming payment_id is the ID of the payment method
        oci_bind_by_name($stmt_insert_session, ':user_id', $user_id);
        oci_bind_by_name($stmt_insert_session, ':mentorship_id', $mentorship_id);
        oci_bind_by_name($stmt_insert_session, ':total_price', $total_price);

        $success = oci_execute($stmt_insert_session);

        if ($success) {
            echo "Session data inserted successfully.";
            // Optionally, redirect to success page or continue with payment process
        } else {
            echo "Failed to insert session data.";
            // Handle failure, perhaps redirect to an error page
        }

        oci_free_statement($stmt_insert_session);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Unauthorized access.";
}

oci_close($conn);
?>
