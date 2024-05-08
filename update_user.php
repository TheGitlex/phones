<?php
// Check if the required parameters are provided
if(isset($_POST['id']) && isset($_POST['column']) && isset($_POST['value'])) {
    // Get the user ID, column name, and new value from the POST parameters
    $userId = $_POST['id'];
    $columnName = $_POST['column'];
    $newValue = $_POST['value'];

    // Perform any necessary validation or sanitation of the input values here

    // Connect to your database
    include("database.php");

    // Prepare the SQL query to update the user's data
    $sql = "UPDATE people SET $columnName = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newValue, $userId);

    // Execute the update query
    if ($stmt->execute()) {
        // If the update is successful, return a success message
        echo "User data updated successfully";
    } else {
        // If there's an error, return an error message
        echo "Error updating user data: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If required parameters are not provided, return an error message
    echo "Missing required parameters";
}

