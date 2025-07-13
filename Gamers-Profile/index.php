<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer's Profile Manager</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styles */

        /* Navigation Styles */
        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 0.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav ul {
            list-style-type: none;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Video Background Styles */
        .video-background {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        /* Main Content Styles */
        .content {
            flex: 1;
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg,rgb(31, 31, 34),rgb(26, 26, 26));
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            position: relative;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 0 20px;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
        }

        .footer-bottom {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="profiles.php">Profiles</a></li>
            <li><a href="games.php">Games</a></li>
            <li><a href="community.php">Community</a></li>
            <li><a href="tournaments.php">Tournaments</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>

    <div class="content">
        <video class="video-background" autoplay muted loop>
            <source src="./assets/back.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <main>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gamers_profile";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT title, description, image FROM games";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="games-container">';
            while($row = $result->fetch_assoc()) {
                echo '<div class="game-box">';
                echo '<img src="assets/images/' . $row["image"] . '" alt="' . $row["title"] . '">';
                echo '<h3>' . $row["title"] . '</h3>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
        <style>
            .games-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
                padding: 20px;
            }

            .game-box {
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                text-align: center;
                width: 300px;
            }

            .game-box img {
                max-width: 100%;
                height: auto;
            }

            .game-box h3 {
                margin: 15px 0;
                font-size: 1.5rem;
            }

            .game-box p {
                padding: 0 15px 15px;
                font-size: 1rem;
                color: #666;
            }
        </style>
    </main>
<!--
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Community</h4>
                <ul>
                    <li><a href="#">Forums</a></li>
                    <li><a href="#">Discord Server</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Support</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect With Us</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; Gamer's Profile. All rights reserved.</p>
        </div>
    </footer>   -->
</body>
</html>
