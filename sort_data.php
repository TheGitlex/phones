<?php
include("database.php");

// Get the Bulgarian column name to sort by from the query string
$bulgarianColumn = $_GET["column"];

// Define a mapping of Bulgarian column names to their English equivalents
$englishColumnMapping = array(
    "id" => "No",
    "name" => "Имена",
    "company" => "Компания",
    "address" => "Адрес",
    "mobile" => "Мобилен телефон",
    "stat" => "Стационарен",
    "fax" => "Факс"
);

$sql = "SELECT * FROM people ORDER BY CASE WHEN $bulgarianColumn IS NULL THEN 1 ELSE 0 END, $bulgarianColumn";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='row_id' id='user_" . $row["id"] . "'>" . $row["id"] . "</td>";
        echo "<td class='name'><span onclick='openPopup(\"" . $row["name"] . "\")'>" . $row["name"] . "</span></td>";
        echo "<td class='editable' data-column='company'>" . $row["company"] . "</td>";
        echo "<td class='editable' data-column='address'>" . $row["address"] . "</td>";
        echo "<td class='editable' data-column='mobile'>" . $row["mobile"] . "</td>";
        echo "<td class='editable' data-column='stat'>" . $row["stat"] . "</td>";
        echo "<td class='editable' data-column='fax'>" . $row["fax"] . "</td>";
        // Add delete button
        echo "<td><button class='editBtn' data-id='" . $row["id"] . "'><i class='fas fa-edit' style='color:orange; filter: brightness(0.5);'> </i></button></td>";
        echo "<td><button class='deleteBtn' data-id='" . $row["id"] . "'><i class='fas fa-times' style='color:red; filter: brightness(0.5);'> </i></button></td>";
         echo "</tr>";
    }
} else {
    // If no rows are returned by the query, display a message
    echo "<tr><td colspan='7'>No data available</td></tr>";
}

$conn->close();

