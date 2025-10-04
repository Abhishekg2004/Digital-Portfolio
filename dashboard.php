<?php
session_start();
include 'db.php'; // Your DB connection file

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch contact messages
$contact_messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!doctype html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Compact card-style table for small screens */
        @media (max-width: 767px) {
            .table-responsive-stack tr {
                display: flex;
                flex-direction: column;
                border-bottom: 1px solid #dee2e6;
                margin-bottom: 0.75rem;
            }
            .table-responsive-stack td,
            .table-responsive-stack th {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem;
                width: 100%;
                border: none;
            }
            .table-responsive-stack thead {
                display: none; /* hide table header on small screens */
            }
            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
            }
        }
    </style>
</head>
<body class="bg-light text-dark">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-3">Contact Messages</h3>
    <div class="table-responsive">
        <table class="table table-striped table-responsive-stack">
            <thead class="table-dark">
                <tr>
                    <th>SLNo.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $i = 1;
    while($row = $contact_messages->fetch_assoc()):
        $formatted_date = date("d-m-Y h:i:s A", strtotime($row['created_at']));
    ?>
    <tr>
        <td data-label="SL No."><?php echo $i++; ?></td>
        <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
        <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
        <td data-label="Message"><?php echo htmlspecialchars($row['message']); ?></td>
        <td data-label="Date"><?php echo $formatted_date; ?></td>
    </tr>
    <?php endwhile; ?>
</tbody>

        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
