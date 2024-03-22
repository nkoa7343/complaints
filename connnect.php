<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Simulating form submission with dummy data
$CustomerFirstName =$_POST['CustomerFirstName'];
$CustomerLastName =$_POST['CustomerLastName'];
$CustomerTelephone =$_POST['ctPhoneNumber']; // Assuming this is a valid format for your BIGINT field
$CustomerEmail =$_POST['ctEmail'];
$EmployeeFirstName=$_POST['emfname'];
$EmployeeLastName=$_POST['emlname'];
$EmployeeNumber=$_POST['emEmployeeNumber'];
$EmployeeDepartment=$_POST['emdepartment'];
$ComplaintType=$_POST['ComplaintType'];
$ProductName=$_POST['pdname'];
$ProductCategory=$_POST['pdcat'];
$_Date=$_POST['_Date'];
$StoreLocation=$_POST['StoreLocation'];
$ComplaintDescription=$_POST['ComplaintDescription'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Correctly format the telephone number for a BIGINT field
$CustomerTelephone = filter_var($CustomerTelephone, FILTER_SANITIZE_NUMBER_INT);

// Prepare statement
$stmt = $conn->prepare("INSERT INTO complaints (CustomerFirstName, CustomerLastName, CustomerTelephone, CustomerEmail, EmployeeFirstName, EmployeeLastName, EmployeeNumber, EmployeeDepartment, ComplaintType, ProductName, ProductCategory, _Date, StoreLocation, ComplaintDescription) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters and execute
if ($stmt) {
    $stmt->bind_param("ssssssisssssss", $CustomerFirstName, $CustomerLastName, $CustomerTelephone, $CustomerEmail, $EmployeeFirstName, $EmployeeLastName, $EmployeeNumber, $EmployeeDepartment, $ComplaintType, $ProductName, $ProductCategory, $_Date, $StoreLocation, $ComplaintDescription);
    if ($stmt->execute()) {
        echo "Complaint Logged Successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
}

$conn->close();
?>