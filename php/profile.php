<?php
session_start();
include('connection.php');
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

try {
    $fetch_sql = "SELECT name, email, address, no_handphone FROM tb_user WHERE id_user = :user_id";
    $fetch_stmt = oci_parse($conn, $fetch_sql);
    oci_bind_by_name($fetch_stmt, ':user_id', $user_id);
    oci_execute($fetch_stmt);
    
    $current_data = oci_fetch_assoc($fetch_stmt);
    
    $name = !empty($_POST['name']) ? $_POST['name'] : $current_data['NAME'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $current_data['EMAIL'];
    $address = !empty($_POST['address']) ? $_POST['address'] : $current_data['ADDRESS'];
    $phone = !empty($_POST['phone']) ? $_POST['phone'] : $current_data['NO_HANDPHONE'];
    
    oci_free_statement($fetch_stmt);

    $sql = "UPDATE tb_user SET name=:name, email=:email, address=:address, no_handphone=:phone WHERE id_user=:user_id";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':address', $address);
    oci_bind_by_name($stmt, ':phone', $phone);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    
    $result = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if ($result) {
        oci_commit($conn); 
        echo "<script>alert('Berhasil Update Data Akun'); window.location.href='../pages/profile.php';</script>";
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
