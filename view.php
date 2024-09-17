<?php
include('./db/connection.php');

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    $sql = "SELECT * FROM client_inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param('i', $client_id);

    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Check if record is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

    } else {
        echo "<p>No record found for the given client ID.</p>";
        exit;
    }

    $result->free();
    $stmt->close();
    
} else {
    echo "<p>No client ID provided.</p>";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        .container {
            background-color: white;
            width: 100%;
            max-width: 45%;
            max-height: 95%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 20px;
            box-sizing: border-box;
            overflow-x: auto;
            white-space: nowrap;
            font-size: 13px;
        }

        .header {
            background-color: #003366;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            margin: 15px 0;
            white-space: nowrap;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #003366;
            width: 30%;
            border-right: 1px solid #ddd;
            color: #f0f0f0;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .table td a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
        }

        .notes {
            margin-top: 20px;
        }

        .notes label {
            display: block;
            margin-bottom: 5px;
            color: #757575;
        }

        .notes textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .buttons button {
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #005599;
        }

        .buttons-2 a {
            color: #003366;
            font-weight: bold;
            text-decoration: none;
        }

        .back-btn {
            align-self: center;
        }

        .back-btn a {
            color: #003366;
            font-weight: bold;
            text-decoration: none;
        }

        .pdf-btn {
            margin-top: 20px;
            width: 100%;
        }

        @media (max-width: 922px) {
            .container {
                background-color: white;
                width: 100%;
                max-width: 80%;
                max-height: 95%;
            }

            .table th,
            .table td {
                font-size: 14px;
            }

            .header {
                font-size: 18px;
            }
        }

        @media (max-width: 868px) {
            .container {
                background-color: white;
                width: 100%;
                max-width: 95%;
                max-height: 95%;
            }

            .table th,
            .table td {
                font-size: 14px;
            }

            .header {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">VIEW JOB SHEET</div>

        <div class="table-container">
            <table class="table">
                <tr>
                    <th>Client Name:</th>
                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                </tr>
                <tr>
                    <th>Contact Info:</th>
                    <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                </tr>
                <tr>
                    <th>Received Date:</th>
                    <td><?php echo htmlspecialchars($row['received_date']); ?></td>
                </tr>
                <tr>
                    <th>Inventory Received:</th>
                    <td><?php echo htmlspecialchars($row['inventory_received']); ?></td>
                </tr>
                <tr>
                    <th>Inventory Image/Document/Video:</th>
                    <td>
                        <?php if (!empty($row['inventory_upload'])): ?>
                            <a href="<?php echo htmlspecialchars($row['inventory_upload']); ?>" target="_blank">View File</a>
                        <?php else: ?>
                            No file available
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Reported Issues:</th>
                    <td><?php echo htmlspecialchars($row['reported_issues']); ?></td>
                </tr>
                <tr>
                    <th>Client Notes:</th>
                    <td><?php echo htmlspecialchars($row['client_notes']); ?></td>
                </tr>
                <tr>
                    <th>Assigned Technician:</th>
                    <td><?php echo htmlspecialchars($row['assigned_technician']); ?></td>
                </tr>
                <tr>
                    <th>Estimated Amount:</th>
                    <td>₹<?php echo htmlspecialchars($row['estimated_amount']); ?></td>
                </tr>
                <tr>
                    <th>Deadline:</th>
                    <td><?php echo htmlspecialchars($row['deadline']); ?></td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            </table>
        </div>

        <div class="notes">
            <label for="note-input">Add or Update Note:</label>
            <textarea id="note-input"></textarea>
            <div class="buttons">
                <button>Save Note</button>
                <div class="buttons-2">
                    <a href='./edit.php?id=<?php echo urlencode($row["id"]); ?>'>
                        Edit
                    </a>
                    <a href='./delete.php?id=<?php echo urlencode($row["id"]); ?>' onclick="return confirm('Are you sure you want to delete this record?');">
                        Delete
                    </a>
                </div>
                <div class="back-btn">
                    <a href='./index.php'>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="pdf-btn">
            <button>Save as PDF</button>
        </div>
    </div>

</body>

</html>
