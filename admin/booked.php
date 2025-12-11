<?php
session_start();
require('../config.php'); // <-- add ../ to go up one level
 // Make sure this path is correct

// Optional: Only allow admin to view this page
// if($_SESSION['usertype_id'] != 1) {
//     header("Location: index.php");
//     exit;
// }

// Fetch all bookings with user and room info
$query = "
    SELECT b.id, l.username, r.name AS room_name, pm.name AS payment_method,
           b.check_in, b.check_out, b.price
    FROM bookings b
    INNER JOIN login l ON b.login_id = l.id
    INNER JOIN rooms r ON b.room_id = r.id
    INNER JOIN payment_method pm ON b.payment_method_id = pm.id
    ORDER BY b.id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booked Rooms</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="adminc/features.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="mb-4">Booked Rooms</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Room</th>
                <th>Payment Method</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Price (₱)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($result && mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['room_name']}</td>
                            <td>{$row['payment_method']}</td>
                            <td>{$row['check_in']}</td>
                            <td>{$row['check_out']}</td>
                            <td>{$row['price']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No bookings found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
