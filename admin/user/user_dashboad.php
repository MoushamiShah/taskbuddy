<?php

// assuming you stored logged-in user's ID in session

include('user_top.php');
include_once('includes/config.php');
$user_id = $_SESSION['id']; 

// 3. Enquiry Counts by Status
$status_counts = [];
$statuses = ['New', 'Completed', 'Pending', 'Canceled'];
foreach ($statuses as $status) {
    $status_counts[$status] = $con->query("SELECT COUNT(*) AS total FROM enquiry_list WHERE status='$status'")
                                  ->fetch_assoc()['total'];
}

// 4. Latest Help Enquiries (limit 5)
$latest_enquiries = $con->query("SELECT * FROM enquiry_list WHERE user_id = '$user_id' ORDER BY created_at DESC");

?>
<!--html code-->
<div class="main-content">
    <section class="section enquiry-list-section">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">

        <!-- Enquiry Counts -->
        <?php foreach ($statuses as $status): ?>
        <div class="col-md-3">
            <div class="card text-white 
                <?php 
                    echo $status == 'New' ? 'bg-warning' : 
                        ($status == 'Completed' ? 'bg-info' : 
                        ($status == 'Pending' ? 'bg-secondary' : 'bg-danger')); 
                ?> mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $status; ?> Enquiries</h5>
                    <p class="card-text display-6"><?php echo $status_counts[$status]; ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <button onclick="window.location.href='enquiry_form.php'" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Add Help Enquiry</button>
  <!-- Latest Enquiries Table -->
<div class="card mt-4">
    <div class="card-header">
        Latest Help Enquiries
    </div>
    <div class="card-body p-0">
        <div class="table-responsive"> <!-- makes table scrollable on small screens -->
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Helper ID</th>
                        <th>User ID</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $latest_enquiries->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['enquiry_id']; ?></td>
                            <td><?php echo $row['helper_id']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    </div>
     </div>
     </table>
              
    
</section>
</div>


<?php
include('footer.php');
?>
