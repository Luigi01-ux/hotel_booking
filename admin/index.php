<?php
session_start();

// Block access if not logged in or not admin
if (!isset($_SESSION['login_id']) || $_SESSION['usertype_id'] != 1) {
    echo "<script>alert('Access denied. Admins only.'); window.location.href='../index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminc/admin.css">
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2 class="logo">🏨 HotelAdmin</h2>
            <nav>
                <a href="rooms.php"><i class="ri-hotel-line"></i> Rooms</a>
                <a href="features.php"><i class="ri-star-line"></i> Room Features</a>
                <a href="facilities.php"><i class="ri-building-line"></i> Facilities</a>
                <a href="messages.php"><i class="ri-mail-line"></i> Messages</a>
                <a href="booked.php"><i class="ri-calendar-check-line"></i> Bookings</a>
            </nav>
            <a href="../logout.php" class="logout"><i class="ri-logout-box-r-line"></i> Logout</a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <h1>Welcome, Admin!</h1>
                <p>Manage your hotel efficiently from the dashboard below.</p>
            </header>

            <section class="cards">
                <div class="card">
                    <i class="ri-hotel-line"></i>
                    <h3>Manage Rooms</h3>
                    <p>Add, edit, or remove available rooms.</p>
                </div>
                <div class="card">
                    <i class="ri-calendar-check-line"></i>
                    <h3>Bookings</h3>
                    <p>View and confirm customer reservations.</p>
                </div>
                <div class="card">
                    <i class="ri-star-line"></i>
                    <h3>Features</h3>
                    <p>Customize room features and benefits.</p>
                </div>
                <div class="card">
                    <i class="ri-mail-line"></i>
                    <h3>Messages</h3>
                    <p>Check guest inquiries and feedback.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
