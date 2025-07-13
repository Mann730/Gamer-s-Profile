<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Gamer's Profile Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .signup-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .signup-header p {
            color: #777;
            margin: 5px 0 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .signup-btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .signup-btn:hover {
            background-color: #218838;
        }
        .error-message,
        .success-message {
            text-align: center;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gamers_profile";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $error_message = "";
    $success_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['name']);
        $uid = trim($_POST['uid']);
        $rank = trim($_POST['rank']);
        $time = trim($_POST['time']);
        $type = trim($_POST['type']);
        $profile_image = $_FILES['profile_image'];

        // Validation
        if (empty($name) || empty($uid) || empty($rank) || empty($time) || empty($type) || empty($profile_image['name'])) {
            $error_message = "All fields are required";
        } else {
            try {
                // Handle file upload
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($profile_image["name"]);
                move_uploaded_file($profile_image["tmp_name"], $target_file);

                // Insert profile data
                $stmt = $conn->prepare("INSERT INTO profiles (name, uid, rank, time, type, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $uid, $rank, $time, $type, $target_file]);

                $success_message = "Profile updated successfully!";
            } catch(PDOException $e) {
                $error_message = "Profile update failed: " . $e->getMessage();
            }
        }
    }
    ?>

    <div class="signup-container">
        <div class="signup-header">
            <h1>Update Profile</h1>
            <p>Update your gaming profile information</p>
        </div>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="uid">UID</label>
                <input type="text" id="uid" name="uid" required>
            </div>

            <div class="form-group">
                <label for="rank">Rank</label>
                <input type="text" id="rank" name="rank" required>
            </div>

            <div class="form-group">
                <label for="time">Time</label>
                <input type="text" id="time" name="time" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" required>
            </div>

            <button type="submit" class="signup-btn">Update Profile</button>
        </form>
    </div>
</body>
</html>
