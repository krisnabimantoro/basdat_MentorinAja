<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$sql = 'SELECT * FROM tb_user ';
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$user = oci_fetch_assoc($stid);
?>
