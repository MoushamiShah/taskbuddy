<?php
include('top.php');
include_once('includes/config.php');

$helper_id = $_SESSION['helper_id']; // helper's session id

// Accept / Reject form handling
if (isset($_POST['action']) && isset($_POST['enquiry_id'])) {
    $enquiry_id = (int) $_POST['enquiry_id'];

    if ($_POST['action'] === 'Accept') {
        $status = 'Pending'; // will appear in your existing Pending List page
    } elseif ($_POST['action'] === 'Reject') {
        $status = 'Canceled'; // will appear in your existing Cancelled List page
    }

    $stmt = $con->prepare("UPDATE enquiry_list SET status=? WHERE enquiry_id=? AND helper_id=?");
    $stmt->bind_param("sii", $status, $enquiry_id, $helper_id);
    $stmt->execute();
}

// Fetch new enquiries for this helper
$stmt = $con->prepare("SELECT enquiry_id, username, subject, description, created_at 
                       FROM enquiry_list 
                       WHERE helper_id = ? AND status = 'New'
                       ORDER BY created_at DESC");
$stmt->bind_param("i", $helper_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!--html code-->
<div class="main-content">
    <section class="section enquiry-list-section">
    <div class="container mt-4">
    <h2>New Enquiries</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Requested At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['enquiry_id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="enquiry_id" value="<?= $row['enquiry_id'] ?>">
                            <button type="submit" name="action" value="Accept" class="btn btn-success btn-sm">Accept</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="enquiry_id" value="<?= $row['enquiry_id'] ?>">
                            <button type="submit" name="action" value="Reject" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</section>
</div>


<?php
include('footer.php');
?>
