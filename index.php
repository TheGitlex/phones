<?php
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Users data</title>
    <link rel="icon" href="https://pngimg.com/d/phone_PNG48982.png" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
    $sql = "SELECT * FROM people";
    $result = $conn->query($sql);
    ?>


<div id="formBG" onclick="closeForm(1)" style="width: 100vw; height:100vh; background-color: rgba(0,0,0,90%); position:fixed; display:none; justify-content:center;">
    <form id="addForm" onclick="event.stopPropagation();" action="formAdd.php" method="post">
        <p style="font-size:x-large;font-weight:600;">Добавяне</p>
        <input placeholder="Имена*" id="formNameInput" name="name" required autocomplete="off">
        <input placeholder="Компания*" id="formCompanyInput" name="company" required autocomplete="off">
        <input placeholder="Адрес*" id="formAddressInput" name="address" required>
        <input placeholder="Мобилен" id="formMobileInput" name="mobile">
        <input placeholder="Стационарен" id="formStatInput" name="stat">
        <input placeholder="Факс" id="formFaxInput" name="fax">
        <button type="submit"> ДОБАВИ </button>
    </form>
</div>
<script>
    function handlePhoneNumberInput(inputId) {
        var input = document.getElementById(inputId);

        // Add "+" symbol automatically when typing starts
        input.addEventListener("input", function(event) {
            if (!input.value.startsWith("+")) {
                input.value = "+" + input.value;
            }
        });

        // Prevent changes to the first character
        input.addEventListener("input", function(event) {
            if (input.selectionStart === 0 && input.selectionEnd === 0) {
                input.value = "+" + input.value.slice(1);
            }
        });

        // Prevent deletion of the first character
        input.addEventListener("keydown", function(event) {
            if (event.key === "Backspace" && input.selectionStart === 0 && input.selectionEnd === 0) {
                event.preventDefault();
            }
        });
    }

    // Apply the function to each input
    handlePhoneNumberInput("formFaxInput");
    handlePhoneNumberInput("formMobileInput");
    handlePhoneNumberInput("formStatInput");
</script>

<script> 

// Prevent the default form submission behavior
document.getElementById("addForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    var formData = new FormData(this); // Create a FormData object from the form data
    var xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest object
    xhr.open("POST", this.action, true); // Open a POST request to the form's action URL
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Handle the successful response, if needed
            console.log(xhr.responseText);
            window.location.reload(); // Reload the page after successful submission
        } else {
            // Handle the error response, if needed
            console.error(xhr.statusText);
        }
    };
    xhr.onerror = function() {
        // Handle errors that occur during the request
        console.error("Error sending request.");
    };
    xhr.send(formData); // Send the form data to the server
});




</script>


<br>
<input id="search" placeholder="Име" style="font-size:large"> <i class="fas fa-search" style="font-size:x-large"></i>
<button id="exportBtn">XLSX</button>
<button id="exportPdfBtn">PDF</button>

<br><br>


<table id="dataTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Имена</th>
            <th>Компания</th>
            <th>Адрес</th>
            <th>Мобилен телефон</th>
            <th>Стационарен</th>
            <th>Факс</th>
        </tr>
    </thead>
    <tbody>
    <?php
if ($result->num_rows > 0) {
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
    echo "<tr><td colspan='7'>No data available</td></tr>";
}
?>

</tbody>
</table>



<div id="editFormOverlay">
    <div id="editFormContainer">
        <form id="editForm">
            <input type="hidden" id="editUserId" name="id">
            <input type="text" id="editName" name="name" placeholder="Име">
            <input type="text" id="editCompany" name="company" placeholder="Компания">
            <input type="text" id="editAddress" name="address" placeholder="Адрес">
            <input type="text" id="editMobile" name="mobile" placeholder="Мобилен">
            <input type="text" id="editStat" name="stat" placeholder="Стационарен">
            <input type="text" id="editFax" name="fax" placeholder="Факс">
            <button type="submit">Промени</button>
        </form>
    </div>
</div>


<script>
        // Function to handle the export to PDF
        function exportToPdf() {
            // Send a request to the server to generate the PDF
            fetch('pdf.php')
                .then(response => response.blob())
                .then(blob => {
                    // Create a blob URL for the PDF
                    const url = window.URL.createObjectURL(blob);
                    
                    // Create a link element and click it to trigger the download
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'table.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                })
                .catch(error => console.error('Error exporting to PDF:', error));
        }

        // Add event listener to the export PDF button
        document.getElementById('exportPdfBtn').addEventListener('click', exportToPdf);
    </script>



<script>

document.getElementById('exportBtn').addEventListener('click', function() {
    // AJAX request to PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'export_excel.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Response handling, if needed
            console.log(xhr.responseText);
        }
    };
    xhr.send();
});


    // Add event listener to the edit form for form submission
document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    
    // Get the form data
    var formData = new FormData(this);
    
    // Send the form data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateForm.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the server response
            console.log(xhr.responseText);
            location.reload();
            // Close the edit form overlay after successful update
            document.getElementById('editFormOverlay').style.display = 'none';
        }
    };
    xhr.send(formData);
});


// Close the edit form overlay when the overlay is clicked
document.getElementById('editFormOverlay').addEventListener('click', function(event) {
    // Check if the click event occurred on the overlay container
    if (event.target.id === 'editFormOverlay') {
        // Hide the edit form overlay
        document.getElementById('editFormOverlay').style.display = 'none';
    }
});


document.querySelectorAll('.editBtn').forEach(function(button) {
    button.addEventListener('click', function() {
        // Get the row ID from the data-id attribute of the clicked button
        var userId = this.getAttribute('data-id');
        
        // Find the corresponding row in the table
        var row = this.closest('tr');
        
        // Fill the edit form fields with the data from the row
        document.getElementById('editUserId').value = userId;
        document.getElementById('editName').value = row.querySelector('.name').textContent.trim();
        document.getElementById('editCompany').value = row.querySelectorAll('.editable')[0].textContent.trim();
        document.getElementById('editAddress').value = row.querySelectorAll('.editable')[1].textContent.trim();
        document.getElementById('editMobile').value = row.querySelectorAll('.editable')[2].textContent.trim();
        document.getElementById('editStat').value = row.querySelectorAll('.editable')[3].textContent.trim();
        document.getElementById('editFax').value = row.querySelectorAll('.editable')[4].textContent.trim();
        
        // Show the edit form overlay
        document.getElementById('editFormOverlay').style.display = 'block';
    });
});

// Close the edit form overlay when the close button is clicked





</script>

<script>
// Add event listener to all delete buttons
document.querySelectorAll('.deleteBtn').forEach(button => {
    button.addEventListener('click', function() {
        // Get the ID of the row to be deleted
        const id = this.getAttribute('data-id');
        
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Изтрий ред?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ИЗТРИЙ',
            cancelButtonText: 'Отказ'
        }).then((result) => {
            // If confirmed, delete the row
            if (result.isConfirmed) {
                // Call delete_user.php with the row ID
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_user.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle response, if needed
                        console.log(xhr.responseText);
                        // Reload the page after deletion
                        location.reload();
                    }
                };
                xhr.send('id=' + id);
            }
        });
    });
});

</script>
<script>
    var input = document.getElementById("search");
    var table = document.getElementById("dataTable");
    input.addEventListener("input", function() {
        var searchText = input.value.toLowerCase();
        var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
            var nameCell = rows[i].getElementsByClassName("name")[0];
            var nameText = nameCell.textContent || nameCell.innerText;
            if (nameText.toLowerCase().indexOf(searchText) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });
</script>

<script>
    document.querySelectorAll('.editable').forEach(function(cell) {
    cell.addEventListener('dblclick', function() {
        editCell(cell);
    });
});

function editCell(cell) {
    var currentValue = cell.textContent.trim();
    
    var input = document.createElement('input');
    input.type = 'text';
    input.value = currentValue;
    
    // Add an id attribute to the input based on the column name
    input.id = cell.classList[0] + '_input'; // Assuming the class contains the column name
    
    cell.innerHTML = '';
    cell.appendChild(input);
    
    input.focus();
    
    input.select();
    
    input.addEventListener('blur', function() {
        updateCell(cell);
    });

    input.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            updateCell(cell);
        }
    });
}

function updateCell(cell) {
    var input = document.getElementById(cell.classList[0] + '_input'); // Get the input by id
    var newValue = input.value; // Get the new value from the input
    var id = cell.parentNode.querySelector('.row_id').textContent; // Get the row ID
    var column = cell.getAttribute('data-column'); // Get the column name

    // Send data to the server to update the corresponding field in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_user.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // Update the cell content if the update was successful
            cell.textContent = newValue;
        }
    };
    xhr.send('id=' + id + '&column=' + column + '&value=' + encodeURIComponent(newValue));
}




</script>




<script>
    const columnMapping = {
        "No": "id",
        "Имена": "name",
        "Компания": "company",
        "Адрес": "address",
        "Мобилен телефон": "mobile",
        "Стационарен": "stat",
        "Факс": "fax"
    };

    document.querySelectorAll("th").forEach(function(th) {
        th.addEventListener("click", function() {
            var englishColumnName = th.innerText.trim();
            var bulgarianColumnName = columnMapping[englishColumnName];
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "sort_data.php?column=" + encodeURIComponent(bulgarianColumnName), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector("tbody").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    });
</script>



<script>
    
   function openPopup(name) {
    var popup = window.open("", "User", "width=1000,height=700");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_data.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            var data = JSON.parse(xhr.responseText);

            popup.document.write("<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Popup</title>");
popup.document.write("<style>");
popup.document.write("table { border-collapse: collapse; width: 100%; }");
popup.document.write("th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }");
popup.document.write("th { background-color: #f2f2f2; }");
popup.document.write("</style>");
popup.document.write("</head><body>");
popup.document.write("<h2>Име: " + name + "</h2>");
popup.document.write("<table>");
popup.document.write("<thead><tr><th>No</th><th>Компания</th><th>Адрес</th><th>Мобилен</th><th>Стационарен</th><th>Факс</th></tr></thead>");
popup.document.write("<tbody>");

for (var i = 0; i < data.length; i++) {
    popup.document.write("<tr>");
    popup.document.write("<td>" + data[i].id + "</td>");
    popup.document.write("<td>" + data[i].company + "</td>");
    popup.document.write("<td>" + data[i].address + "</td>");
    popup.document.write("<td>" + data[i].mobile + "</td>");
    popup.document.write("<td>" + data[i].stat + "</td>");
    popup.document.write("<td>" + data[i].fax + "</td>");
    popup.document.write("</tr>");
}

popup.document.write("</tbody>");
popup.document.write("</table>");
popup.document.write("</body></html>");
        }
    };
    xhr.send("name=" + name);
}

    </script>




<br>
<button id="addRowBtn"> + </button>
<button onclick="closeForm(0)" id="formBtn"> + </button>


<script>
    document.getElementById("addRowBtn").addEventListener("click", function() {
        var newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td></td>
            <td><input type="text" placeholder="Име"></td>
            <td><input type="text" placeholder="Компания"></td>
            <td><input type="text" placeholder="Адрес"></td>
            <td><input type="text" placeholder="Мобилен"></td>
            <td><input type="text" placeholder="Стационарен"></td>
            <td><input type="text" placeholder="Факс"></td>
            <td><button class="saveBtn">Запази</button></td>
        `;

        document.querySelector("tbody").appendChild(newRow);
    });

    document.querySelector("tbody").addEventListener("click", function(event) {
    if (event.target.classList.contains("saveBtn")) {
        var inputs = event.target.parentNode.parentNode.querySelectorAll("input");
        var data = {};
        var isValid = true; 

        inputs.forEach(function(input) {
            var placeholder = input.getAttribute("placeholder");
            var value = input.value.trim();

            if (value !== "") {
                if (placeholder === "Мобилен" || placeholder === "Стационарен" || placeholder === "Факс") {
                    if (!value.startsWith("+")) {
                        alert("Невалиден код. Номерът трябва да започва с '+'.");
                        isValid = false; 
                        return; 
                    }
                }
            }

            data[placeholder] = value;
        });

        if (!isValid) {
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_person.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                // Remove the save button after successful submission
                event.target.parentNode.removeChild(event.target);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: " Добавен",
                    showConfirmButton: false,
                    timer: 750,
                    backdrop: 'rgba(0, 0, 0, 0.1)' 
                });
            }
        };
        xhr.send(JSON.stringify(data));
    }
});


function closeForm(n) {
    if (n === 1) {
        document.getElementById("formBG").style.display = "none";
    } else if (n === 0) {
        document.getElementById("formBG").style.display = "inline";
    } else {
    }
}

</script>




</body>
</html>
