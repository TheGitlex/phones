<?php
// Check if ID parameter is provided
if (isset($_POST['id'])) {
    // Database connection
    include("database.php");

    // Sanitize input ID
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // SQL to delete user by ID
    $sql = "DELETE FROM people WHERE id = '$id'";

    // Execute the delete query
    if ($conn->query($sql) === TRUE) {
        // Return success message
        echo "User deleted successfully";
    } else {
        // Return error message
        echo "Error deleting user: " . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    // If ID parameter is not provided, return error message
    echo "ID parameter is missing";
}
