<?php
// Include the necessary files
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

include("database.php"); 

$sql = "SELECT * FROM people";
$result = $conn->query($sql);

// Create a new PhpSpreadsheet spreadsheet object
$spreadsheet = new Spreadsheet();

// Get the active sheet
$sheet = $spreadsheet->getActiveSheet();

// Set headers with light blue background
$headerStyle = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'CCE5FF'],
    ],
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Имена');
$sheet->setCellValue('C1', 'Компания');
$sheet->setCellValue('D1', 'Адрес');
$sheet->setCellValue('E1', 'Мобилен');
$sheet->setCellValue('F1', 'Стационарен');
$sheet->setCellValue('G1', 'Факс');

// Set data from the users table
$rowNumber = 2; // Start from row 2 (row 1 is for headers)
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row["id"]);
        $sheet->setCellValue('B' . $rowNumber, $row["name"]);
        $sheet->setCellValue('C' . $rowNumber, $row["company"]);
        $sheet->setCellValue('D' . $rowNumber, $row["address"]);
        $sheet->setCellValue('E' . $rowNumber, $row["mobile"]);
        $sheet->setCellValue('F' . $rowNumber, $row["stat"]);
        $sheet->setCellValue('G' . $rowNumber, $row["fax"]);
        $rowNumber++;
    }
}

// Auto-size columns to fit content
foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Align numbers to the right and text to the left
$sheet->getStyle('A2:G' . ($rowNumber - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A2:G' . ($rowNumber - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('table.xlsx');

// Close the database connection
$conn->close();
