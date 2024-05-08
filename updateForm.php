<?php
// Check if the required parameters are provided
if(isset($_POST['id'])) {
    // Get the user ID and other updated fields from the POST parameters
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $company = $_POST['company'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $stat = $_POST['stat'];
    $fax = $_POST['fax'];

    // Perform any necessary validation or sanitation of the input values here

    // Connect to your database
    include("database.php");

    // Prepare the SQL query to update the user's data
    $sql = "UPDATE people SET name = ?, company = ?, address = ?, mobile = ?, stat = ?, fax = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $company, $address, $mobile, $stat, $fax, $userId);

    // Execute the update query
    if ($stmt->execute()) {
        // If the update is successful, return a success message
      
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
