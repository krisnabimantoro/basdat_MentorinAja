<?php
session_start();
include('connection.php');  

$name = $_POST['name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$id_role = $_POST['role'];


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
  
    $sql = "INSERT INTO tb_user (name, date_of_birth, email, address, regis_date, TB_ROLE_ID_ROLE, no_handphone, password) 
            VALUES (:name, TO_DATE(:dob, 'YYYY-MM-DD'), :email, :address, SYSDATE, :id_role, :phone, :password)";
    
    $stmt = oci_parse($conn, $sql);
    
    
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':dob', $dob);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':address', $address);
    oci_bind_by_name($stmt, ':id_role', $id_role);
    oci_bind_by_name($stmt, ':phone', $phone);
    oci_bind_by_name($stmt, ':password', $hashed_password);


    $result = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if ($result) {
        oci_commit($conn); 
        echo "<script>alert('Berhasil Membuat Akun'); window.location.href='../pages/login.html';</script>";
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