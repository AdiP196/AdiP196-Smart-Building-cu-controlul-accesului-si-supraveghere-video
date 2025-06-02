<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Smart Home</a>
            <div class="d-flex">
                <a href="/attendance.php" class="btn btn-outline-light me-2">Istoric log-uri RFID</a>
                <a href="/users.php" class="btn btn-outline-light me-2">Utilizatori</a>
                <a href="/camera.php" class="btn btn-outline-light me-2">Camera Feed</a>
                <a href="/sensors.php" class="btn btn-outline-light">Date Senzori</a>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Buna ziua,</h1>
        <p>Aceasta este pagina principala a sistemului smart home</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="/users.php" class="btn btn-secondary">Utilizatori</a>
            <a href="/attendance.php" class="btn btn-secondary">Istoric log-uri RFID</a>
            <a href="/camera.php" class="btn btn-secondary">Camera Feed</a>
            <a href="/sensors.php" class="btn btn-secondary">Datele de la senzori</a>
        </div>
    </div>
</body>
</html>
