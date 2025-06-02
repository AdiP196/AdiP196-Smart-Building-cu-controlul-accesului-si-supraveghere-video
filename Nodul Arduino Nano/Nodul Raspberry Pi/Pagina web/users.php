<?php
require 'common.php';

// Interogare toți utilizatorii
$result = $mysqli->query("SELECT id, name, rfid_uid FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Utilizatori - Attendance System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Smart Home</a>
        <div class="d-flex">
            <a href="index.php" class="btn btn-outline-light me-2">Pagina Principală</a>
            <a href="attendance.php" class="btn btn-outline-light me-2">Istoric log-uri</a>
            <a href="users.php" class="btn btn-light">Utilizatori</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Utilizatori activi</h2>
        <a href="add_users.php" class="btn btn-success">➕ Adaugă utilizator</a>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Utilizatorul a fost șters cu succes.</div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nume</th>
                <th>UID RFID</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['rfid_uid']) ?></td>
                    <td>
                        <a href="delete_user.php?id=<?= $user['id'] ?>"
                           onclick="return confirm('Ești sigur că vrei să ștergi acest utilizator?');"
                           class="btn btn-danger btn-sm">
                            
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
