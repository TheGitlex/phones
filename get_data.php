<?php
// Include the database connection file
include("database.php");

// Retrieve the clicked name from the request
$name = $_POST['name'];

// Prepare and execute the query to fetch data for the clicked name
$sql = "SELECT * FROM people WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

// Store the fetched data in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();

// Send the fetched data as JSON response
echo json_encode($data);
