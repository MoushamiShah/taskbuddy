<?php
include('top.php');
include_once('includes/config.php');
$helper_id = $_SESSION['helper_id'];

// ✅ Update status if form submitted
if (isset($_POST['enquiry_id']) && isset($_POST['status'])) {
    $enquiry_id = intval($_POST['enquiry_id']);
    $status = $_POST['status'];

    // Allowed statuses to prevent invalid updates
    $allowed_status = ['New', 'Pending', 'Completed', 'Canceled'];
    if (in_array($status, $allowed_status)) {
        $stmt = $con->prepare("UPDATE enquiry_list SET status = ?, updated_at = NOW() WHERE enquiry_id = ?");
        $stmt->bind_param("si", $status, $enquiry_id);

        if ($stmt->execute()) {
            // ✅ Show confirmation and reload
            echo "<script>alert('Status updated to $status'); window.location.href='helper_pending_list.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error updating status');</script>";
        }
        $stmt->close();
    }
}

// ✅ Keep only pending enquiries in this table
$status_filter = 'Pending';
$sql = "SELECT * FROM enquiry_list WHERE status = ? AND helper_id = ? ORDER BY created_at DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $status_filter, $helper_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4>Pending Enquiry List</h4>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <tr>
                                    <th>Enquiry ID</th>
                                    <th>Helper ID</th>
                                    <th>User ID</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>

                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['enquiry_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['helper_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                                           <td>
                                            <!--making this status into drop down menu-->
                                           <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo $row['enquiry_id']; ?>">
                                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                                 
                                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Completed" <?php echo ($row['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                       
                                                    </select>
                                                </form>
                                            </td>

                            
                                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                            <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No enquiries found with status: " . htmlspecialchars($status_filter) . "</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('footer.php');
?>
