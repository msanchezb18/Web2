<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include '../Proyecto/Configuración/config.php';
    include_once('codigos/enca.inc');
    $sql = "SELECT id, username, comment FROM comments";
    $result = $conn->query($sql);
    ?>
    <meta charset="UTF-8">
    <title>Formulario de Comentarios</title>
    <style>
        h1, h2 {
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #d1d1d1; 
            border-radius: 10px; 
            box-sizing: border-box; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-top: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }   

        input[type="submit"] {
        background-color: rgb(116, 81, 199);
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #d9c56c;
        }
        

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgb(116, 81, 199);
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
    <?php
    include_once('codigos/nav.inc');
    ?>
    </header>
    <h1>Deja tu comentario</h1>
    <h3>Tu opinión es invaluable para nosotros. ¡Déjanos saber cómo podemos mejorar o qué te gustó más! 
        Estamos ansiosos por escuchar tus comentarios. Gracias por ser parte de nuestra comunidad.</h3>
    <div class="container">
        <form method="post" action="./Metodos/GuardarComentarios.php">
            <div>
                <label for="usuario">Usuario: </label>
                <input type="text" id="usuario" name="usuario" placeholder="Digite su usuario">
            </div>
            <div>
                <label for="mensaje">Mensaje: </label>
                <input type="text" id="mensaje" name="mensaje" placeholder="Digite su mensaje">
            </div>
            <div>
                <input type="submit" value="Enviar">
            </div> 
        </form>
    </div>
    <h2>Comentarios</h2>
    <?php 
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<table>";
        echo "<thead><tr><th>Usuario</th><th>Comentario</th></tr></thead>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['username'] . ":</td><td>" . $row['comment'] . "</td></tr>";
        }    
        
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container'>";
        echo "No hay comentarios para mostrar.";
        echo "</div>";
    }
    ?>
    <footer>
    <?php
    include_once('codigos/footer.inc');
    ?>
    </footer>
</body>
</html>
