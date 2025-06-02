<?php
require 'common.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $uid = trim($_POST['rfid_uid']);

    if (!empty($name) && !empty($uid)) {
        $stmt = $mysqli->prepare("INSERT INTO users (name, rfid_uid) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $uid);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>✅ Utilizatorul a fost adăugat cu succes.</div>";
        } else {
            $message = "<div class='alert alert-danger'> Eroare: " . htmlspecialchars($stmt->error) . "</div>";
        }

        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>⚠️Numele și UID-ul sunt obligatorii.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă utilizator - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Smart Home</a>
        <div class="d-flex">
            <a href="index.php" class="btn btn-outline-light me-2">Inapoi la pagina Principala</a>
            <a href="users.php" class="btn btn-outline-light">Utilizatori</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Adaugă utilizator RFID</h2>
    </div>

    <?= $message ?>

    <form method="POST" action="add_user.php" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="name" class="form-label">Nume:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rfid_uid" class="form-label">UID Card:</label>
            <input type="text" name="rfid_uid" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary"> Adaugă utilizator</button>
    </form>
</div>

</body>
</html>
