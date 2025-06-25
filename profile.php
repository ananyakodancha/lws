<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="usern"><b>Hello <?php echo htmlspecialchars($user_data['full_name']); ?>!!</font></b></div>
    <div class="wrapper">
        <div class="right">
            <h3><center>Account Information</center></h3>
            <hr/><br/>
            <center><p>User Name: <?php echo htmlspecialchars($user_data['full_name']); ?></p><br>
            <p>User Email: <?php echo htmlspecialchars($user_data['email']); ?></p><br>
            <p>Phone Number: <?php echo htmlspecialchars($user_data['mobile_number']); ?></p><br></center>


            <hr/>
            <h3><center>LOGOUT & SECURITY</center></h3>
            <center><a href="index.php"><button class="btn4">Home</button></a>
            <a href="updateProfile.php?id=<?php echo $user_data['user_id']; ?>"><button class="btn1">Update</button></a>
            <a href="logout.php"><button class="btn1">Logout</button></a>
            <a href="deleteProfile.php?id=<?php echo $user_data['user_id']; ?>"><button class="btn1">Delete</button></a></center>
        </div>
    </div>
</body>
</html>
