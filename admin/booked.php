<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booked Rooms</title>
    <link rel="stylesheet" href="style.css"> <!-- link your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #2d89ef;
            color: white;
            text-align: center;
            padding: 20px;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .back-link {
            display: block;
            text-align: center;
            margin: 20px;
        }
        .back-link a {
            color: #2d89ef;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Booked Rooms</h1>

    <table>
        <tr>
            <th>#</th>
            <th>Guest Name</th>
            <th>Room</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Status</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            $count = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $count++ . "</td>
                        <td>" . $row['guest_name'] . "</td>
                        <td>" . $row['room_name'] . "</td>
                        <td>" . $row['check_in'] . "</td>
                        <td>" . $row['check_out'] . "</td>
                        <td><span style='color:green; font-weight:bold;'>" . $row['status'] . "</span></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No booked rooms found.</td></tr>";
        }
        ?>
    </table>

    <div class="back-link">
        <a href="index.php">← Back to Admin Dashboard</a><br><br>
    </div>
</body>
</html>

<?php
$conn->close();
?>
