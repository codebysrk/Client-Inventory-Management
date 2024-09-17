<?php
include('./db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client-id']; // Hidden input field

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

    // Handle file upload
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
    if ($inventory_upload == "") {
        $sql = "SELECT inventory_upload FROM client_inventory WHERE client_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $inventory_upload = $row['inventory_upload'];
    }

    $sql = "UPDATE client_inventory 
            SET client_name = ?, contact_info = ?, received_date = ?, inventory_received = ?, inventory_upload = ?, reported_issues = ?, client_notes = ?, assigned_technician = ?, deadline = ?, estimated_amount = ?, status = ? 
            WHERE client_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("ssssssssssss", $client_name, $contact_info, $received_date, $inventory_received, $inventory_upload, $reported_issues, $client_notes, $assigned_technician, $deadline, $estimated_amount, $status, $client_id);

    if ($stmt->execute()) {
        echo "Job sheet updated successfully.";
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
