<?php
include_once('includes/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get current status
    $result = $con->query("SELECT status FROM helper_login WHERE helper_id = $id");
    $row = $result->fetch_assoc();
    $newStatus = $row['status'] ? 0 : 1;

    // Update status
    $con->query("UPDATE helper_login SET status = $newStatus WHERE helper_id = $id");

    header("Location: helper_login.php");
    exit();
}
?>
