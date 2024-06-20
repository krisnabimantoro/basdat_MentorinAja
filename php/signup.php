<?php
session_start();
include('connection.php'); // Ensure this connects to your Oracle database using OCI8

$name = $_POST['name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$id_role = $_POST['role'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Prepare the SQL statement
    $sql = "INSERT INTO tb_user (name, date_of_birth, email, address, regis_date, TB_ROLE_ID_ROLE, no_handphone, password) 
            VALUES (:name, TO_DATE(:dob, 'YYYY-MM-DD'), :email, :address, SYSDATE, :id_role, :phone, :password)";
    
    $stmt = oci_parse($conn, $sql);
    
    // Bind parameters
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':dob', $dob);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':address', $address);
    oci_bind_by_name($stmt, ':id_role', $id_role);
    oci_bind_by_name($stmt, ':phone', $phone);
    oci_bind_by_name($stmt, ':password', $hashed_password);

    // Execute the statement
    $result = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if ($result) {
        oci_commit($conn); // Commit the transaction
        echo "<script>alert('Berhasil Membuat Akun'); window.location.href='../login.html';</script>";
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
?>
