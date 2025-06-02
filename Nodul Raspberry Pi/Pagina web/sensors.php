<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Smart Home - Date Senzori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <h1>Datele de la senzori</h1>
        <p class="mb-4">Date actualizate automat la fiecare 1 secunde.</p>

        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <pre id="sensor-data" class="mb-0" style="white-space: pre-wrap; font-size: 1.2rem;">
Se încarcă datele...
                </pre>
            </div>
        </div>
    </div>

    <script>
        function incarcaDate() {
            fetch('sensor_data.txt?nocache=' + new Date().getTime())
                .then(response => response.text())
                .then(data => {
                    document.getElementById('sensor-data').innerText = data.trim();
                })
                .catch(() => {
                    document.getElementById('sensor-data').innerText = "Eroare la încărcarea datelor.";
                });
        }
        incarcaDate();  // încărcare inițială
        setInterval(incarcaDate, 1000);  // actualizare la 5 secunde
    </script>
</body>
</html>
