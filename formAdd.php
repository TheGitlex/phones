<?php
// Include the database connection file
include("database.php");

// Retrieve the form data sent via POST
$name = $_POST["name"];
$company = $_POST["company"];
$address = $_POST["address"];
$mobile = $_POST["mobile"];
$stat = $_POST["stat"];
$fax = $_POST["fax"];

// Insert the data into the database
$sql = "INSERT INTO people (name, company, address, mobile, stat, fax) VALUES ('$name', '$company', '$address', '$mobile', '$stat', '$fax')";
if ($conn->query($sql) === TRUE) {
    header("Location:index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

