<?php
include('top.php');
include_once('includes/config.php');

// Validate & get user_id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("User ID not provided or invalid.");
}
$user_id = intval($_GET['id']);

// Get user info
$user_sql = "SELECT * FROM user WHERE id = ?";
$stmt_user = $con->prepare($user_sql);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Count how many times this user has taken the service
$service_count_sql = "SELECT COUNT(*) AS total_services FROM enquiry_list WHERE user_id = ?";
$stmt_count = $con->prepare($service_count_sql);
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$service_count_result = $stmt_count->get_result();
$service_count = $service_count_result->fetch_assoc()['total_services'];

// Get enquiry history
$history_sql = "SELECT * FROM enquiry_list WHERE user_id = ? ORDER BY created_at DESC";
$stmt_history = $con->prepare($history_sql);
$stmt_history->bind_param("i", $user_id);
$stmt_history->execute();
$history_result = $stmt_history->get_result();
?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">

                <!-- User Details Card -->
                <div class="card shadow-lg mb-4">
                    <div class="card-header">
                        <h4>User Details</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th>Full Name</th>
                                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo $user['status'] ? 'Active' : 'Inactive'; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Services Taken</th>
                                    <td><?php echo htmlspecialchars($service_count); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Enquiry History Card -->
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4>Enquiry History</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Enquiry ID</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($history_result->num_rows > 0): ?>
                                        <?php while ($row = $history_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['enquiry_id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No enquiries found for this user.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-3">
                    <a href="login_history.php" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </div>
    </section>
</div>

<?php
include('footer.php');
?>
