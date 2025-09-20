<?php

include('user_top.php');
include_once('includes/config.php');
$user_id = $_SESSION['id']; 

// Set filter
$status_filter = 'Pending';

// Fetch enquiries securely
$sql = "SELECT * FROM enquiry_list WHERE status = ? && user_id =$user_id ORDER BY created_at DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $status_filter);
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
                                            <td><?php echo htmlspecialchars($row['status']); ?></td>
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
