<?php
//@session_start();

// Check if the user is logged in and has requested to edit their account
if (isset($_SESSION['username'])) {
    $user_session_name = $_SESSION['username'];
    
    // Fetch user data from the database
    include '../cnk/connect.php';  // Include database connection
    $select_query = "SELECT * FROM `users` WHERE `username` = '$user_session_name'";
    $result_query = mysqli_query($conn, $select_query);
    
    // Check if the query was successful and data exists
    if ($result_query && mysqli_num_rows($result_query) > 0) {
        $row_fetch = mysqli_fetch_assoc($result_query);
        
        // Fetch user details
        $user_id = $row_fetch['id'];  // Use 'id' instead of 'user_id'
        $username = $row_fetch['username'];
        $user_email = $row_fetch['email'];  // Corrected 'user_email'
        $user_phone = $row_fetch['phone_number'];  // Corrected 'user_mobile'
    } else {
        echo "<script>alert('User not found');</script>";
        exit();
    }
} else {
    echo "<script>alert('You must be logged in to edit your account');</script>";
    exit();
}

// Update user data when the form is submitted
if (isset($_POST['user_update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user_username']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);  // Corrected 'user_mobile'
    
    // Update query
    $update_query = "UPDATE `users` 
                     SET `username` = '$username', `email` = '$user_email', `phone_number` = '$user_phone' 
                     WHERE `id` = $user_id";
    
    // Execute the update query
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully');</script>";
        echo "<script>window.location.href = 'profile.php';</script>"; // Redirect to profile page
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}
?>

<!-- HTML form for editing user details -->
<div class="w3-card w3-padding w3-light-grey" style="text-align:center; max-width: 500px; margin: auto;">
    <h2>Edit Account</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Username Field -->
        <div class="form-outline mb-4">
            <input type="text" name="user_username" class="form-control w-100" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        
        <!-- Email Field -->
        <div class="form-outline mb-4">
            <input type="email" name="user_email" class="form-control w-100" value="<?php echo htmlspecialchars($user_email); ?>" required>
        </div>

        <!-- Mobile Number Field -->
        <div class="form-outline mb-4">
            <input type="text" name="user_phone" class="form-control w-100" value="<?php echo htmlspecialchars($user_phone); ?>" required>
        </div>

        <!-- Submit Button -->
        <input type="submit" value="Update" name="user_update" class="btn bg-info py-2 px-3 border-0 w-100">
    </form>                                   
</div>

<!-- Add the following CSS for mobile responsiveness -->
<style>
    /* Make the form elements full-width on smaller screens */
    @media screen and (max-width: 768px) {
        .form-outline {
            width: 100%; /* Full width for all form fields */
        }

        .form-control {
            width: 100%; /* Full width for input fields */
        }

        .btn {
            width: 100%; /* Full width for buttons */
        }
    }

    /* Extra small screen adjustments */
    @media screen and (max-width: 480px) {
        .w3-card {
            padding: 16px; /* Adjust card padding */
        }

        .w3-card h2 {
            font-size: 1.5rem; /* Adjust heading size */
        }

        .form-outline {
            margin-bottom: 20px; /* Add some space between fields */
        }
    }
</style>
