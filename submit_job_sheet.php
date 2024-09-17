<?php
include('./db/connection.php');

// Function to generate random alphanumeric string with minimum 6 characters
function generateClientID($length = 6) {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = generateClientID(); 
    // Debug: Check if client_id is generated
    var_dump($client_id);

    $client_name = $_POST['client-name'];
    $contact_info = $_POST['contact-info'];
    $received_date = $_POST['received-date'];
    $inventory_received = $_POST['inventory-received'];
    $reported_issues = $_POST['reported-issues'];
    $client_notes = $_POST['client-notes'];
    $assigned_technician = $_POST['assigned-technician'];
    $deadline = $_POST['deadline'];
    $estimated_amount = $_POST['estimated-amount'];
    $status = $_POST['status'];

    $inventory_upload = "";
    if (isset($_FILES['inventory-upload']) && $_FILES['inventory-upload']['error'] == 0) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['inventory-upload']['name']);
        if (move_uploaded_file($_FILES['inventory-upload']['tmp_name'], $upload_file)) {
            $inventory_upload = $upload_file;
        } else {
            echo "File upload failed.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO client_inventory (client_id, client_name, contact_info, received_date, inventory_received, inventory_upload, reported_issues, client_notes, assigned_technician, deadline, estimated_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("ssssssssssss", $client_id, $client_name, $contact_info, $received_date, $inventory_received, $inventory_upload, $reported_issues, $client_notes, $assigned_technician, $deadline, $estimated_amount, $status);

    if ($stmt->execute()) {
        echo "Job sheet submitted successfully.";

        var_dump($stmt->affected_rows);

        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
