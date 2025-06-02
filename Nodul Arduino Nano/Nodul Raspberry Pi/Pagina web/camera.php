<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camera Feed - Attendance System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Attendance System</a>
        <div class="d-flex">
            <a href="attendance.php" class="btn btn-outline-light me-2">Attendance</a>
            <a href="users.php" class="btn btn-outline-light me-2">Users</a>
            <a href="camera.php" class="btn btn-light me-2">Camera Feed</a>
            <a href="sensors.php" class="btn btn-outline-light">Sensor Data</a>
        </div>
    </div>
</nav>

<div class="container text-center mt-5">
    <h2>Live Camera Feed</h2>
    <div class="mt-4">
        <img src="http://192.168.121.176:5000/video" class="img-fluid rounded shadow" alt="Camera Feed">
    </div>
</div>

</body>
</html>
