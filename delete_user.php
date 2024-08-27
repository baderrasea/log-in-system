<?php
header('Content-Type: application/json');

// Database connection parameters
$host = 'localhost';
$dbname = 'db_mosnad';
$user = 'root';
$password = '';

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user ID from POST request
    $user_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($user_id > 0) {
        // Prepare SQL delete statement
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Send success response
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            // Send failure response
            echo json_encode(['success' => false, 'message' => 'Error deleting user']);
        }
    } else {
        // Send invalid ID response
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    }

} catch (PDOException $e) {
    // Handle any connection or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

// Close the connection
$conn = null;
?>
