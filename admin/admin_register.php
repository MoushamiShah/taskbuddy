<?php
include('top.php');
include_once('includes/config.php');
?>

<div class="main-content">
    <section class="section login-history-section">
<?php

// Fetch helpers from helper_login table
$helper_sql = "SELECT helper_id, helper_name FROM helper_login ORDER BY helper_name ASC";
$helper_result = $con->query($helper_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $helper_id   = intval($_POST['helper_id']);
    $user_id     = intval($_POST['user_id']);
    $subject     = trim($_POST['subject']);
    $description = trim($_POST['description']);
    $status      = "New"; // default status

    if (!empty($helper_id) && !empty($user_id) && !empty($subject) && !empty($description)) {
        $stmt = $con->prepare("INSERT INTO enquiry_list (helper_id, user_id, subject, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("iisss", $helper_id, $user_id, $subject, $description, $status);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Enquiry submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Please fill in all required fields.</p>";
    }
}
?>

            <div class="form-container">
        <form method="POST" class="admin-form" onsubmit="return validatePassword()">

        <h2>Admin Registration</h2>

        <label>Fullname:</label>
        <input type="text" name="fullname" placeholder="Enter your Fullname" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter valid Email" required>
        
        <label>Phone number:</label>
        <input type="number" name="phone" placeholder="Enter your 10 digi mobile number" required>


        <label>Username:</label>
        <input type="text" name="username" placeholder="enter your username" required>
            <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>

                <label>Confirm Password:</label>
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" required>



        <button type="submit">Register Admin</button>
    </form>
</div>
  <script>
function validatePassword() {
    let pass = document.getElementById("password").value;
    let confirmPass = document.getElementById("confirmpassword").value;
    let errorMsg = document.getElementById("error");

    if (pass !== confirmPass) {
        errorMsg.textContent = "Passwords do not match!";
        return false; // Stop form submission
    }

    errorMsg.textContent = "";
    return true; // Allow form submission
}
</script>
     </div>
        </div>
    </section>
</div>

<?php
include('footer.php');
?>
            
 