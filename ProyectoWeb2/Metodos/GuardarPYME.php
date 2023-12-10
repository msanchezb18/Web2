<?php
include '../Configuración/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $InfoPersona = $_POST['InfoPersona'];
    $email = $_POST['email'];
    $telefono = $_POST['Telefono'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $horario = $_POST['horario'];
    $direccion_empresa = $_POST['direccion_empresa'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['Imagen'];

    $sql = "INSERT INTO PYME (informacion_personal, correo_electronico, telefono, nombre_empresa, horario, direccion, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $InfoPersona, $email, $telefono, $nombre_empresa, $horario, $direccion_empresa, $descripcion, $imagen);
    $stmt->execute();
    header('Location: ../RegistroPYME.php');
}

?>