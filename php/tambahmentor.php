<?php
session_start();
include('connection.php'); // Ensure this connects to your Oracle database using OCI8

// Retrieve form data
$specialization = $_POST['bidang_mentor'];
$availability = $_POST['offline_online'];
$description = $_POST['deskripsi'];
$price = $_POST['harga'];
$rate = null; // Assuming rate is not provided, you may want to add it to the form

// Assuming TB_STATUS_ID_STATUS and TB_USER_ID_USER are constants or come from session/user data
$tb_status_id_status = 1; // Example value
$tb_user_id_user = 6; // Example value\

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
            echo "<script>alert('Berhasil Menambahkan Mentorship'); window.location.href='../pages/success.html';</script>";
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
