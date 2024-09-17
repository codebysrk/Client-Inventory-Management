<?php
include('./db/connection.php');

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    $sql = "SELECT * FROM client_inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>No record found for the given client ID.</p>";
        exit;
    }
} else {
    echo "<p>No client ID provided.</p>";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Job Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            max-width: 700px;
            height: 90vh;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        h2 {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin: 0;
            border-radius: 10px 10px 0 0;
        }

        .form-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #003366;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: auto;
            margin-bottom: 20px;
        }

        input[type="submit"]:hover {
            background-color: #005599;
        }
        @media (max-width: 768px) {
            .container {
                width: 80%;
                height: auto;
                max-height: 90vh;
            }

            input[type="submit"] {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 18px;
                padding: 10px 0;
            }

            .container {
                width: 95%;
                height: auto;
                max-height: 100vh;
            }

            input[type="submit"] {
                font-size: 14px;
                padding: 8px 16px;
            }

            input[type="text"],
            input[type="date"],
            input[type="file"],
            textarea,
            select {
                padding: 8px;
            }

            label {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>EDIT JOB SHEET</h2>
        <div class="form-content">
            <form action="update_job_sheet.php" method="post" enctype="multipart/form-data">
                <!-- Hidden field to hold the client_id -->
                <input type="hidden" name="client-id" value="<?php echo htmlspecialchars($row['client_id']); ?>" />

                <label for="client-name">Client Name:</label>
                <input type="text" id="client-name" name="client-name" value="<?php echo htmlspecialchars($row['client_name']); ?>" required />

                <label for="contact-info">Contact Info (Phone 10 nos):</label>
                <input type="text" id="contact-info" name="contact-info" value="<?php echo htmlspecialchars($row['contact_info']); ?>" required />

                <label for="received-date">Received Date:</label>
                <input type="date" id="received-date" name="received-date" value="<?php echo htmlspecialchars($row['received_date']); ?>" required />

                <label for="inventory-received">Inventory Received:</label>
                <input type="text" id="inventory-received" name="inventory-received" value="<?php echo htmlspecialchars($row['inventory_received']); ?>" required />

                <label for="inventory-upload">Upload Inventory Image/Document/Video:</label>
                <input type="file" id="inventory-upload" name="inventory-upload" />

                <label for="reported-issues">Reported Issues:</label>
                <textarea id="reported-issues" name="reported-issues"><?php echo htmlspecialchars($row['reported_issues']); ?></textarea>

                <label for="client-notes">Client Notes:</label>
                <textarea id="client-notes" name="client-notes"><?php echo htmlspecialchars($row['client_notes']); ?></textarea>

                <label for="assigned-technician">Assigned Technician:</label>
                <input type="text" id="assigned-technician" name="assigned-technician" value="<?php echo htmlspecialchars($row['assigned_technician']); ?>" />

                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($row['deadline']); ?>" />

                <label for="estimated-amount">Estimated Amount:</label>
                <input type="text" id="estimated-amount" name="estimated-amount" value="<?php echo htmlspecialchars($row['estimated_amount']); ?>" />

                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="in-progress" <?php echo ($row['status'] == 'in-progress') ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo ($row['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                </select>

                <input type="submit" value="Save Changes" />
            </form>
        </div>
    </div>
</body>

</html>
