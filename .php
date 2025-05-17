<?php
// Start session
session_start();

// Check if OTP is set in the session
if (!isset($_SESSION['MFA_Token'])) {
    echo "<script>alert('No OTP found. Please login again.'); window.location.href = 'sign-in.php';</script>";
    exit();
}

// Initialize variables
$error = "";

// Handle OTP validation
if (isset($_POST['verify'])) {
    $enteredOtp = trim($_POST['otp']);

    if ($enteredOtp === $_SESSION['MFA_Token']) {
        // OTP is correct
        unset($_SESSION['MFA_Token']); // Clear OTP from session after successful validation
        echo "<script>alert('OTP verified successfully!'); window.location.href = 'my-account.php';</script>";
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="Cascade Sheets/hf.css">
    <link rel="stylesheet" href="Cascade Sheets/login.css">
</head>
<body>
    <?php include "header.php"; ?>

    <div style="text-align: center;">
        <h1>Verify OTP</h1>
        <p>Please enter the OTP sent to your email.</p>

        <form class="form" action="" method="POST" autocomplete="off">
            <label>Enter OTP</label><br>
            <input type="text" name="otp" placeholder="Enter OTP" required><br><br>

            <button type="submit" name="verify">Verify OTP</button>
        </form>

        <?php if ($error): ?>
            <p style="color: red;"> <?php echo $error; ?> </p>
        <?php endif; ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
