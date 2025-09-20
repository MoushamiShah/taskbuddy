<?php
include('top.php');
include_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $createddate = date('Y-m-d H:i:s');

    if ($password !== $confirmpassword) {
        $error_msg = "Passwords do not match!";
    } else {
        $sql = "INSERT INTO user (fullname, email, phone, username, password, confirmpassword, createddate)
                VALUES ('$fullname', '$email', '$phone', '$username', '$password', '$confirmpassword', '$createddate')";
        
        if ($con->query($sql)) {
            echo "<script>
                alert('User registered successfully!');
                window.location.href = 'user_dashboard.php';
            </script>";
            exit;
        } else {
            $error_msg = "Error: " . $con->error;
        }
    }
}
?>

<div class="main-content">
    <section class="section">

        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="mb-4 text-center">User Registration</h2>

                <?php if (!empty($error_msg)): ?>
                    <p class="error-msg text-center"><?php echo htmlspecialchars($error_msg); ?></p>
                <?php endif; ?>

                <form method="POST" onsubmit="return validatePassword()">

                    <div class="mb-3">
                        <label class="form-label">Fullname:</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Enter your fullname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter valid email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter your 10-digit mobile number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password:</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm password" required>
                        <small id="error" class="text-danger"></small>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </form>
            </div>
        </div>

    </section>
</div>

<style>
.error-msg {
    color: red;
    font-weight: bold;
}
</style>

<script>
function validatePassword() {
    let pass = document.getElementById("password").value;
    let confirmPass = document.getElementById("confirmpassword").value;
    let errorMsg = document.getElementById("error");

    if (pass !== confirmPass) {
        errorMsg.textContent = "Passwords do not match!";
        return false;
    }
    errorMsg.textContent = "";
    return true;
}
</script>

<?php include('footer.php'); ?>
