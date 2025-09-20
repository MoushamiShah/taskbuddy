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
                    
                    <!-- Card Header -->
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

                    <!-- Card Body with Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped text-center" >
                                <tr>
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
                                        $statusText = ($row['status'] == 1) ? 'Active' : 'Inactive';
                                        $toggleAction = ($row['status'] == 1) ? 'Deactivate' : 'Activate';
                                        $btnClass = ($row['status'] == 1) ? 'btn-danger' : 'btn-success';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($row['login_time']); ?></td>
                                            <td><?php echo $statusText; ?></td>
                                            <td>
                                                <a href="toggle_status.php?id=<?php echo $row['id']; ?>" class="btn btn-sm <?php echo $btnClass; ?>">
                                                    <?php echo $toggleAction; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="user_detail_history.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Details</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No login history found</td></tr>";
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
