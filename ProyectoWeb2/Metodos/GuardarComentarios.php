<?php
include '../Configuración/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['usuario'];
    $comment = $_POST['mensaje'];

    $sql = "INSERT INTO comments (username, comment) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $comment);
    $stmt->execute();
    header('Location: ../Comentar.php');
}
?>