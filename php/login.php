<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email and Password are required!";
    } else {
        $sql = 'SELECT * FROM tb_user WHERE email = :email';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':email', $email);

        oci_execute($stid);

        $user = oci_fetch_assoc($stid);

        if ($user) {
            if (password_verify($password, $user['PASSWORD'])) {
                $_SESSION['user_id'] = $user['ID_USER'];
                $_SESSION['email'] = $user['EMAIL'];
                $_SESSION['role'] = $user['TB_ROLE_ID_ROLE'];
                header("Location: ../pages/searching.php");
                exit();
            } else {
                echo "<script>alert('Password salah'); window.location.href='../pages/login.html';</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan'); window.location.href='../pages/login.html';</script>";
        }

        oci_free_statement($stid);
    }
}

oci_close($conn);
?>
