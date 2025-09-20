<?php
include('top.php');
include_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['password'] !== $_POST['confirmpassword']) {
        echo "<div class='alert alert-danger'>Passwords do not match!</div>";
    } else {
        $helper_name = $_POST['helper_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $helpername = $_POST['helpername'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_plain = $_POST['password'];
        $created_at = date('Y-m-d H:i:s');
        $status = 1;

        // Handle photo upload
        $photo = '';
        if (!empty($_FILES['helper_photo']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $photoName = time() . "_" . basename($_FILES['helper_photo']['name']);
            $targetFile = $targetDir . $photoName;
            if (move_uploaded_file($_FILES['helper_photo']['tmp_name'], $targetFile)) {
                $photo = $photoName;
            }
        }

        $sql = "INSERT INTO helper_login (helper_name, email, phone, helper_photo, helpername, password, confirmpassword, created_at, status)
                VALUES ('$helper_name','$email','$phone','$photo','$helpername','$password','$password_plain','$created_at','$status')";

        if ($con->query($sql)) {
            echo "<div class='alert alert-success'>Helper registered successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($con->error) . "</div>";
        }
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="mb-4">Helper Registration</h2>
                <form method="POST" enctype="multipart/form-data" onsubmit="return validatePassword()">

                    <div class="mb-3">
                        <label class="form-label">Full Name:</label>
                        <input type="text" name="helper_name" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter valid email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter your mobile number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Photo:</label>
                        <input type="file" name="helper_photo" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Helper Username:</label>
                        <input type="text" name="helpername" class="form-control" placeholder="Enter your username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password:</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm password" required>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="helper_dashboard.php" class="btn btn-secondary">Cancel</a>

                </form>
            </div>
        </div>
    </section>
</div>

<script>
function validatePassword() {
    let pass = document.getElementById("password").value;
    let confirmPass = document.getElementById("confirmpassword").value;
    if (pass !== confirmPass) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>

<?php include('footer.php'); ?>
