<?php
session_start();
include('connection.php'); // Ensure this connects to your Oracle database using OCI8
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Retrieve form data
$specialization = $_POST['bidang_mentor'];
$tb_status_id_status = $_POST['offline_online'];
$availability = "Yes";
$description = $_POST['deskripsi'];
$price = $_POST['harga'];
$rate = null; 
$tb_user_id_user = $user_id; // Example value\

$upload_dir = '../uploads/';
$image_name = $_FILES['upload_image']['name'];
$image_tmp_name = $_FILES['upload_image']['tmp_name'];
$target_file = $upload_dir . basename($image_name);

if (move_uploaded_file($image_tmp_name, $target_file)) {
    
    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO TB_MENTORSHIP (SPECIALIZATION, AVAILABILITY, RATE, DESCRIPTION, PRICE,IMG, TB_STATUS_ID_STATUS, TB_USER_ID_USER)
                VALUES (:specialization, :availability, :rate, :description, :price,:img, :tb_status_id_status, :tb_user_id_user)";
        

        

        $stmt = oci_parse($conn, $sql);
        
        // Bind parameters
        oci_bind_by_name($stmt, ':specialization', $specialization);
        oci_bind_by_name($stmt, ':availability', $availability);
        oci_bind_by_name($stmt, ':rate', $rate);
        oci_bind_by_name($stmt, ':description', $description);
        oci_bind_by_name($stmt, ':price', $price);
        oci_bind_by_name($stmt, ':img', $image_name);
        oci_bind_by_name($stmt, ':tb_status_id_status', $tb_status_id_status);
        oci_bind_by_name($stmt, ':tb_user_id_user', $tb_user_id_user);
    
        // Execute the statement
        $result = oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    
        if ($result) {
            oci_commit($conn); // Commit the transaction
            echo "<script>alert('Berhasil Menambahkan Mentorship'); window.location.href='../pages/searching.php';</script>";
            exit();
        } else {
            $e = oci_error($stmt); // For error handling
            echo "Error: " . $e['message'];
        }
    
        oci_free_statement($stmt);
        oci_close($conn);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }


}
?>
