<?php
include_once('includes/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get current status
    $result = $con->query("SELECT status FROM user WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $newStatus = $row['status'] ? 0 : 1;
        $con->query("UPDATE user SET status = $newStatus WHERE id = $id");
    }
}

header("Location: login_history.php");
exit();
?>
