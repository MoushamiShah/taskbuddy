<?php 
include('top.php');
include_once('includes/config.php');

// SQL query to fetch login history
$sql = "SELECT lh.login_time, 
               u.fullname, 
               u.username, 
               u.phone, 
               u.status, 
               u.id
        FROM login_history lh
        JOIN user u ON lh.user_id = u.id
        ORDER BY lh.login_time DESC";

$result = $con->query($sql);
?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Login History</h4>
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
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">
                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Mobile</th>
                                    <th>Login Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Details</th>
                                </tr>

                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Status text
                                        $statusText = ($row['status'] == 1) ? 'Active' : 'Inactive';
                                        ?>
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                                        id="checkbox-<?php echo $row['id']; ?>">
                                                    <label for="checkbox-<?php echo $row['id']; ?>" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($row['login_time']); ?></td>
                                            <td><?php echo $statusText; ?></td>
                                            <td>
                                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                            <td>
                                                <a href="view_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
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
