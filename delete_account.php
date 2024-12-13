<?php 
include '../cnk/connect.php'; // Include database connection
?>

<div class="w3-card w3-padding w3-light-grey" style="text-align:center; max-width: 500px; margin: auto;">
    <form action="" method="post" class="mt-5">
        <!-- Delete Button -->
        <div class="form-outline mb-4 text-danger">
            <input type="submit" class="form-control w-100" name="delete" value="Delete">
        </div>
        
        <!-- Don't Delete Button -->
        <div class="form-outline mb-4 text-success">
            <input type="submit" class="form-control w-100" name="dont_delete" value="Don't Delete">
        </div>
    </form>
</div>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {
    $username_session = $_SESSION['username'];

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $username_session);
        $result = $stmt->execute();

        if ($result) {
            session_destroy();
            echo "<script>alert('Account deleted successfully.');</script>";
            echo "<script>window.open('../index.php', '_self');</script>";
        } else {
            echo "<script>alert('Error deleting account.');</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['dont_delete'])) {
        echo "<script>window.open('profile.php', '_self');</script>";
    }
} else {
    echo "<script>alert('You are not logged in.');</script>";
    echo "<script>window.open('../index.php', '_self');</script>";
}
?>

<!-- Add the following CSS for mobile responsiveness -->
<style>
    /* Ensure the form elements take full width on smaller screens */
    @media screen and (max-width: 768px) {
        .form-outline {
            width: 100%; /* Full width for form fields */
        }

        .form-control {
            width: 100%; /* Full width for input fields */
        }

        .btn {
            width: 100%; /* Full width for buttons */
        }
    }

    /* Adjust form container for extra small screens */
    @media screen and (max-width: 480px) {
        .w3-card {
            padding: 16px; /* Adjust card padding for smaller screens */
        }

        .w3-card h2 {
            font-size: 1.5rem; /* Adjust heading size */
        }

        .form-outline {
            margin-bottom: 20px; /* Space between fields */
        }
    }
</style>
