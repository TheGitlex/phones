<?php
// Include the database connection file
include("database.php");

// Retrieve the data sent via POST
$data = json_decode(file_get_contents("php://input"), true);

// Extract the values from the data array
$name = $data["Име"];
$company = $data["Компания"];
$address = $data["Адрес"];
$mobile = $data["Мобилен"];
$stat = $data["Стационарен"];
$fax = $data["Факс"];

// Insert the data into the database
$sql = "INSERT INTO people (name, company, address, mobile, stat, fax) VALUES ('$name', '$company', '$address', '$mobile', '$stat', '$fax')";
if ($conn->query($sql) === TRUE) {
    echo "New record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

