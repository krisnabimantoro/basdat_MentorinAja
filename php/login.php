<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email and Password are required!";
    } else {
        // Prepare the SQL statement to fetch the user data by email
        $sql = 'SELECT * FROM tb_user WHERE email = :email';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':email', $email);

        oci_execute($stid);

        // Fetch the user data
        $user = oci_fetch_assoc($stid);

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['PASSWORD'])) {
                // Start the session and redirect to the searching page
                $_SESSION['user_id'] = $user['ID_USER'];
                $_SESSION['email'] = $user['EMAIL'];
                header("Location: ../pages/searching.html");
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
