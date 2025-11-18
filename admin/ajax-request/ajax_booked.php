<?php
// Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to database
$conn = new mysqli("localhost", "root", "", "hotelbooking");

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Determine what kind of request is sent
$action = $_POST['action'] ?? '';

switch ($action) {

    // ===================== ADD BOOKING =====================
    case 'add_booking':
        $room_id = (int)$_POST['room_id'];
        $guest_name = trim($_POST['guest_name']);
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];

        $stmt = $conn->prepare("INSERT INTO bookings (room_id, guest_name, check_in, check_out) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $room_id, $guest_name, $check_in, $check_out);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Booking added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add booking: ' . $stmt->error]);
        }

        $stmt->close();
        break;


    // ===================== FETCH BOOKINGS =====================
    case 'get_bookings':
        $result = $conn->query("
            SELECT b.id, r.name AS room_name, b.guest_name, b.check_in, b.check_out 
            FROM bookings b 
            JOIN rooms r ON b.room_id = r.id
        ");

        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }

        echo json_encode(['status' => 'success', 'data' => $bookings]);
        break;


    // ===================== DEFAULT =====================
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

$conn->close();
?>
