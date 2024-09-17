<?php
include('./db/connection.php');

$sql = "SELECT client_id, id, client_name, contact_info, received_date, inventory_received, inventory_upload, 
        reported_issues, client_notes, assigned_technician, estimated_amount, deadline, status 
        FROM client_inventory
        ORDER BY client_name";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Client Management Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      background-color: #f2f2f2;
      margin: 0;
    }

    .container-fluid {
      margin-top: 20px;
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      background-color: #003366;
      color: white;
      padding: 10px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      text-align: center;
      margin-bottom: 20px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .form-control,
    .btn {
      border-radius: 5px;
    }

    .btn-primary {
      background-color: #003366;
      border-color: #003366;
    }

    .btn-primary:hover {
      background-color: #002244;
      border-color: #002244;
    }

    .btn-warning {
      background-color: #ffcc00;
      border-color: #ffcc00;
    }

    .btn-danger {
      background-color: #cc0000;
      border-color: #cc0000;
    }

    .input-group .btn {
      margin-left: 10px;
    }

    .table-wrapper {
      height: 500px;
      overflow-y: auto;
    }

    .table thead {
      position: sticky;
      top: 0;
      background-color: #003366;
      color: white;
      z-index: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .table-responsive {
      overflow-x: auto;
    }

    .footer {
      background-color: #003366;
      color: white;
      text-align: center;
      padding: 10px;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      margin-top: 20px;
    }

    @media (max-width: 768px) {
      .container-fluid {
        padding: 15px;
      }

      .input-group {
        flex-direction: column;
      }

      .input-group .form-control,
      .input-group .btn {
        width: 100%;
        margin-bottom: 10px;
      }

      .input-group .btn {
        margin-left: 0;
      }

      table thead th,
      table td {
        font-size: 14px;
      }

      .footer {
        padding: 15px;
      }
    }

    @media (max-width: 576px) {
      h2 {
        font-size: 18px;
      }

      .btn {
        font-size: 12px;
        padding: 5px 10px;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <h2 class="text-center">HARDIK TRADERS - CLIENT MANAGEMENT DASHBOARD</h2>

    <div class="my-3">
      <div class="input-group">
        <input
          type="text"
          id="search-bar"
          class="form-control"
          placeholder="Search by Client Name or ID..." />
        <button class="btn btn-primary" id="search-button">Search</button>
      </div>
    </div>

    <div class="d-flex justify-content-center my-3">
      <a href="form.html"><button class="btn btn-primary">New Job Sheet</button></a>
    </div>

    <div class="table-wrapper">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Contact Info</th>
            <th>Received Date</th>
            <th>Inventory Received</th>
            <th>Reported Issues</th>
            <th>Client Notes</th>
            <th>Assigned Technician</th>
            <th>Estimated Amount</th>
            <th>Deadline</th>
            <th>Status</th>
            <!-- <th>Image</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="client-data">
          <?php
          if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $index . "</td>";
              echo "<td>" . $row["client_id"] . "</td>";
              echo "<td>" . $row["client_name"] . "</td>";
              echo "<td>" . $row["contact_info"] . "</td>";
              echo "<td>" . $row["received_date"] . "</td>";
              echo "<td>" . $row["inventory_received"] . "</td>";
              echo "<td>" . $row["reported_issues"] . "</td>";
              echo "<td>" . $row["client_notes"] . "</td>";
              echo "<td>" . $row["assigned_technician"] . "</td>";
              echo "<td>₹" . $row["estimated_amount"] . "</td>";
              echo "<td>" . $row["deadline"] . "</td>";
              echo "<td>" . $row["status"] . "</td>";
              // echo '<td><img src="' . $row["inventory_upload"] . '" alt="Uploaded Image" width="100" height="100"></td>';
              echo "<td>
              <div class='d-flex'>
                <a href='./view.php?id=" . $row["id"] . "'>
                  <button class='btn btn-primary btn-sm mx-1'>View</button>
                </a>
                <a href='./edit.php?id=" . $row["id"] . "'>
                  <button class='btn btn-warning btn-sm mx-1'>Edit</button>
                </a>
                <a href='./delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                  <button class='btn btn-danger btn-sm mx-1'>Delete</button>
                </a>
              </div>
            </td>";

              echo "</tr>";
              $index++;
            }
          } else {
            echo "<tr><td colspan='14'>No clients found</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div class="footer">© 2024 Hardik Traders</div>
  </div>

  <script>
    // Search functionality
    function searchTable() {
      const searchValue = document
        .getElementById("search-bar")
        .value.toLowerCase();
      const rows = document.querySelectorAll("tbody tr");

      rows.forEach((row) => {
        const clientID = row.cells[1].textContent.toLowerCase();
        const clientName = row.cells[2].textContent.toLowerCase();
        row.style.display =
          clientID.includes(searchValue) || clientName.includes(searchValue) ? 
          "" : 
          "none";
      });
    }

    document
      .getElementById("search-bar")
      .addEventListener("keyup", searchTable);
    document
      .getElementById("search-button")
      .addEventListener("click", searchTable);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
