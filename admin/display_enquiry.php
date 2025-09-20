<?php
include('top.php');
include_once('includes/config.php');

// Update status if form submitted
if (isset($_POST['enquiry_id']) && isset($_POST['status'])) {
    $enquiry_id = intval($_POST['enquiry_id']);
    $status = $_POST['status'];

    $allowed_status = ['New', 'Pending', 'Completed', 'Canceled'];
    if (in_array($status, $allowed_status)) {
        $stmt = $con->prepare("UPDATE enquiry_list SET status = ?, updated_at = NOW() WHERE enquiry_id = ?");
        $stmt->bind_param("si", $status, $enquiry_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all enquiries with helper names
$sql = "SELECT e.*, h.helper_name
        FROM enquiry_list e
        JOIN helper_login h ON e.helper_id = h.helper_id
        ORDER BY e.created_at DESC";
$result = $con->query($sql);
?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4>Enquiry List</h4>
                        <div class="card-header-form">
                            <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Helper Name</th>
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
                                            <td><?php echo htmlspecialchars($row['helper_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo $row['enquiry_id']; ?>">
                                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                                        <option value="New" <?php echo ($row['status'] == 'New') ? 'selected' : ''; ?>>New</option>
                                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Completed" <?php echo ($row['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                        <option value="Canceled" <?php echo ($row['status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                            <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No enquiries found</td></tr>";
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
