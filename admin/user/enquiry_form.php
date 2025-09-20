<?php
session_start(); 
include('user_top.php');
include_once('includes/config.php');

// Fetch helpers
$helper_sql = "SELECT helper_id, helper_name FROM helper_login ORDER BY helper_name ASC";
$helper_result = $con->query($helper_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $helper_id   = intval($_POST['helper_id']);
    $user_id     = intval($_SESSION['id']);
    $subject     = trim($_POST['subject']);
    $description = trim($_POST['description']);
    $status      = "New";

    if (!empty($helper_id) && !empty($user_id) && !empty($subject) && !empty($description)) {
        $stmt = $con->prepare("INSERT INTO enquiry_list (helper_id, user_id, subject, description, status, created_at, updated_at) 
                               VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("iisss", $helper_id, $user_id, $subject, $description, $status);

        if ($stmt->execute()) {
            echo "<p class='success-msg'>Enquiry submitted successfully!</p>";
        } else {
            echo "<p class='error-msg'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='error-msg'>Please fill in all required fields.</p>";
    }
}
?>
<style>
.admin-form {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
}
</style>

<div class="main-content">
    <section class="section enquiry-section">
        <div class="container-fluid">
            <form method="POST" class="admin-form">

                <h2>Enquiry Form</h2>

                <label>Helper:</label>
                <select name="helper_id" required>
                    <option value="">-- Select Helper --</option>
                    <?php
                    if ($helper_result->num_rows > 0) {
                        while ($row = $helper_result->fetch_assoc()) {
                            echo "<option value='{$row['helper_id']}'>{$row['helper_id']} - {$row['helper_name']}</option>";
                        }
                    }
                    ?>
                </select>

                <label>Subject:</label>
                <input type="text" name="subject" placeholder="Enter Subject" required>

                <label>Description:</label>
                <textarea name="description" placeholder="Enter Description" required></textarea>

                <button type="submit" onclick="this.disable='true'" class="mt-4">Submit Enquiry</button>

            </form>
        </div>
    </section>
</div>

<?php include('../footer.php'); ?>
