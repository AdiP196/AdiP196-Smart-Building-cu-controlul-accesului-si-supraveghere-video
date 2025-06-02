<?php
require 'common.php';

// Preluăm datele de prezență
$result = $mysqli->query(
    "SELECT users.name, attendance.clock_in
     FROM attendance
     JOIN users ON attendance.user_id = users.id
     ORDER BY attendance.clock_in DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Smart Home</a>
        <div class="d-flex" >
            <a href="index.php" class="btn btn-light me-2">Pagina Principala</a>
            <a href="attendance.php" class="btn btn-outline-light me-2">Istoric log-uri RFID</a>
            <a href="users.php" class="btn btn-outline-light">Utilizatori</a>
            <a href="camera.php" class="btn btn-outline-light me-2">Camera Feed</a>
            <a href="sensors.php" class="btn btn-outline-light">Date senzori</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Prezență recentă RFID</h2>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nume</th>
                <th>Dată și oră</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['clock_in'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
