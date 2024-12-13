<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../includes/connect.php');

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to view your orders'); window.location.href = 'login.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$get_user = "SELECT * FROM user_table WHERE username=?";
$stmt = mysqli_prepare($con, $get_user);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row_fetch = mysqli_fetch_assoc($result)) {
    $user_id = $row_fetch['user_id'];
} else {
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}
?>
<div class="content">
    <h2 class="text-center mt-30">Order Details</h2>
    <form action="" method="post">
    <table class="table table-bordered text-center bg-light">
    <?php
        $get_order_details = "SELECT * FROM user_orders WHERE user_id = ?";
        $stmt_orders = mysqli_prepare($con, $get_order_details);
        mysqli_stmt_bind_param($stmt_orders, 'i', $user_id);
        mysqli_stmt_execute($stmt_orders);
        $result_orders = mysqli_stmt_get_result($stmt_orders);
        $number = 1;

        if (mysqli_num_rows($result_orders) > 0) {
            while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                $order_id = $row_orders['order_id'];
                $amount_due = htmlspecialchars($row_orders['amount_due']);
                $total_products = htmlspecialchars($row_orders['total_products']);
                $invoice_number = htmlspecialchars($row_orders['invoice_number']);
                $order_date = htmlspecialchars($row_orders['order_date']);
                $quantity = htmlspecialchars($row_orders['quantity']);
                $new_add = htmlspecialchars($row_orders['new_add']);
                $order_status = $row_orders['order_status'] == 'pending' ? 'Incomplete' : 'Complete';
            ?>
            <tr>
                <th>Sl No</th>
                <td><?php echo $number; ?></td>
            </tr>
            <tr>
                <th>Amount Due</th>
                <td>₹<?php echo $amount_due; ?></td>
            </tr>
            <tr>
                <th>Total Products</th>
                <td><?php echo $total_products; ?></td>
            </tr>
            <tr>
                <th>Invoice Number</th>
                <td><?php echo $invoice_number; ?></td>
            </tr>
            <tr>
                <th>Date</th>
                <td><?php echo $order_date; ?></td>
            </tr>
            <tr>
                <th>New Address</th>
                <td><?php echo $new_add; ?></td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td><?php echo $quantity; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge <?php echo ($order_status == 'Complete' ? 'bg-success' : 'bg-warning'); ?>">
                        <?php echo $order_status; ?>
                    </span>
                </td>
            </tr>

            <tr>
                <th>Cancel Order</th>
                <td>
                    <a href="delete_pending.php?delete_pending=<?php echo $order_id; ?>" class="text-dark">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>


            <tr>
                <td colspan="2" class="text-center">
                    <?php if ($order_status == 'Complete') { ?>
                        <span class="text-success">Delivered</span>
                    <?php } else { ?>
                        <a href="confirm_payment.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary">Complete Payment</a>
                    <?php } ?>
                </td>
            </tr>
            <?php
                $number++;
            }
        } else {
            echo "<tr><td colspan='9' class='text-center text-danger'>No orders found.</td></tr>";
        }
    ?>
        </table>
    </form>
</div>

