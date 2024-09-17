<?php
include('./db/connection.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM client_inventory WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Record deleted successfully");
    } else {
        header("Location: index.php?msg=Error deleting record");
    }
    $stmt->close();
}
$conn->close();