<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $email = $_SESSION['email'];

    // Update plain password (only for learning)
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $stmt->execute([$new_password, $email]);

    echo "<script>alert('Password updated successfully!'); window.location='login.php';</script>";
    session_destroy(); // Clear session
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('background.jpg'); /* Replace with your image */
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
    }

    .container {
      background: rgba(255, 255, 255, 0.9);
      width: 350px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .show-toggle {
      display: flex;
      align-items: center;
      justify-content: left;
      font-size: 14px;
      color: #555;
    }

    .show-toggle input[type="checkbox"] {
      margin-right: 5px;
    }

    button {
      background-color: #007BFF;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

  </style>
</head>
<body>

<div class="container">
  <h2>Reset Your Password</h2>
  <form method="POST">
    <input type="password" name="password" id="password" required placeholder="Enter new password">
    
    <div class="show-toggle">
      <input type="checkbox" onclick="togglePassword()"> Show Password
    </div>

    <button type="submit">Change Password</button>
  </form>
</div>

<script>
  function togglePassword() {
    var input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
  }
</script>

</body>
</html>