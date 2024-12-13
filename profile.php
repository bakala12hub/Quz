<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Profile Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* General Styles */
        body {
            background-color: #0D47A1;
            color: white;
            font-family: 'Montserrat', sans-serif;
        }

        /* Responsive Sidebar */
        @media screen and (max-width: 768px) {
            .w3-sidebar {
                width: 200px; /* Reduce width for smaller screens */
                position: absolute; /* Position it over the main content */
                display: none; /* Initially hide */
            }
            .w3-sidebar.show {
                display: block; /* Show when toggled */
            }
        }

        /* Responsive Grid Layout */
        @media screen and (max-width: 768px) {
            .w3-row {
                display: flex;
                flex-direction: column; /* Stack elements vertically */
            }
            .w3-col {
                width: 100%; /* Make columns full width */
                margin-bottom: 20px; /* Add spacing between stacked elements */
            }
        }


        /* Header for Mobile */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: #1976D2;
        }

        header .w3-bar-item {
            font-size: 18px;
            color: white;
        }

        /* Profile Section Styling */
        .profile-icon {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ddd;
            margin: 20px auto;
            line-height: 150px;
            font-size: 50px;
            color: #555;
            text-align: center;
        }
        .profile-container {
            text-align: center;
            padding: 20px;
            background-color: #BBDEFB;
            border-radius: 10px;
            margin-top: 20px;
        }

        .profile-container h3 {
            color: #FF5722;
        }

        .profile-container p {
            color: white;
        }

        /* Card Styling */
        .w3-card {
            padding: 20px;
            background-color: #E3F2FD;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Footer Styling */
        footer {
            background-color: #1976D2;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        /* Mobile Friendly Layout */
        @media screen and (max-width: 600px) {
            .w3-bar-item {
                font-size: 16px;
            }

            .profile-container h3 {
                font-size: 22px;
            }

            .profile-container p {
                font-size: 16px;
            }

            .footer-container {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" id="mySidebar">
    <button class="w3-bar-item w3-button w3-large" onclick="toggleSidebar()">Close &times;</button>
    <a href="../index.php" class="w3-bar-item w3-button">Home</a>
    <a href="profile.php?edit_account" class="w3-bar-item w3-button">Edit Account</a>
    <a href="profile.php?delete_account" class="w3-bar-item w3-button">Delete Account</a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding" onclick="document.getElementById('newsletter').style.display='block'">Login</a>
    <a href="Q/logout.php" class="w3-bar-item w3-button">Logout</a>
</div>

<!-- Header for Mobile -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge" style="height:70px;display:flex;align-items:center;justify-content: space-between;">
    <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
    <div style="color:black;">.SUBHAM.</div>
    <button class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </button>
</header>

<!-- Profile Section -->
<div class="w3-content w3-padding-64">
<div class="profile-icon w3-center">👤</div>
    <div class="profile-container">
        <?php
        if (isset($_SESSION['username'])) {
            $username = htmlspecialchars($_SESSION['username']);
            echo "<h3>Hello, $username!</h3>";

            // Fetch user details from the database
            include '../cnk/connect.php';

            // Check database connection
            if ($conn->connect_error) {
                die("<p>Database connection failed: " . $conn->connect_error . "</p>");
            }

            // Query to fetch user details
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            if (!$stmt) {
                die("<p>Query preparation failed: " . $conn->error . "</p>");
            }
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>Please <a href='../Q/login.html' style='color: #FF5722;'>log in</a> to view your profile.</p>";
        }

    // Include different pages based on URL parameters
    if (isset($_GET['edit_account'])) {
        include('edit_account.php');
    }
    if (isset($_GET['my_orders'])) {
        include('user_orders.php');
    }
    if (isset($_GET['delete_account'])) {
        include('delete_account.php');
    }
    if (isset($_GET['Contact_us'])) {
        include('Contact_us.php');
    }
    ?>
</div>
</div>


<script>
    function toggleSidebar() {
        document.getElementById('mySidebar').classList.toggle('show');
    }
</script>

</body>
</html>