<?php
require 'common.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: users.php?deleted=1");
        exit();
    } else {
        echo "Eroare la ștergere: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
} else {
    echo "ID invalid.";
}
?>
