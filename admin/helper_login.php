<?php
include('top.php');
include_once('includes/config.php');

// Fetch helpers
$sql = "SELECT helper_id, helper_name, email, phone, helper_photo, status
        FROM helper_login
        ORDER BY helper_id DESC";
$result = $con->query($sql);
?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4>Helper Login List</h4>
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
                                    <th>Helper ID</th>
                                    <th>Helper Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>

                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $statusText = $row['status'] ? 'Active' : 'Inactive';
                                        $toggleAction = $row['status'] ? 'Deactivate' : 'Activate';
                                        $btnClass = $row['status'] ? 'btn-danger' : 'btn-success';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['helper_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['helper_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($row['helper_photo']); ?>" 
                                                     alt="Helper Photo" 
                                                     class="img-thumbnail" style="width:60px;height:60px;">
                                            </td>
                                            <td><?php echo $statusText; ?></td>
                                            <td>
                                                <a href="toggle_helper_status.php?id=<?php echo $row['helper_id']; ?>" 
                                                   class="btn btn-sm <?php echo $btnClass; ?>">
                                                    <?php echo $toggleAction; ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No helper login records found</td></tr>";
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
