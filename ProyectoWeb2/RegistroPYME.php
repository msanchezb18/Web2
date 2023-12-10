<!DOCTYPE html>
<html lang="es">
<head>
    <title>Formulario PYME</title>
    <?php
    include_once('codigos/enca.inc');
    ?>
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
        
    <h1 class = "Textos text-center">Formulario registro PYME</h1>
    <div class="container ">
        <form method="post" action="./Metodos/GuardarPYME.php" onsubmit="return validarFormulario()">
            <div>
                <label for="mensaje" class="form-label">Informacion Personal: </label>
                <input type="text" class="form-control border-success" id="InfoPersona" name="InfoPersona" placeholder="Digite su Informacion Personal">
            </div>
            <div >
                <label for="mensaje" class="form-label">Correo Electrónico: </label>
                <input type="text" class="form-control border-success" id="email" name="email" placeholder="Digite su Correo Electrónico">
            </div>
            <div >
                <label for="mensaje" class="form-label">Telefono: </label>
                <input type="text" class="form-control border-success" id="Telefono" name="Telefono" placeholder="Digite su Correo Telefono">
            </div>
            <div >
                <label for="mensaje" class="form-label">Nombre empresa: </label>
                <input type="text" class="form-control border-success" id="nombre_empresa" name="nombre_empresa" placeholder="Digite su Nombre empresa">
            </div>
            <div >
                <label for="mensaje" class="form-label">Horario: </label>
                <input type="text" class="form-control border-success" id="horario" name="horario" placeholder="Digite su Horario">
            </div>
            <div >
                <label for="mensaje" class="form-label">Dirección:</label>
                <input type="text" class="form-control border-success" id="direccion_empresa" name="direccion_empresa" placeholder="Digite su Dirección">
            </div>
            <div >
                <label for="mensaje" class="form-label">Descripción:</label>
                <input type="text" class="form-control border-success" id="descripcion" name="descripcion" placeholder="Digite su Descripción">
            </div>
            <div >
                <label for="mensaje" class="form-label">Imagen:</label>
                <input type="file" class="form-control border-success" id="Imagen" name="Imagen" placeholder="Digite su Descripción">
            </div>
            <br>
            <div >
                <input type="submit" value="Enviar">
            </div> 
        </form>


        <!--<script>
    function validarFormulario() {
        var infoPersona = document.getElementById("InfoPersona").value;
        var email = document.getElementById("email").value;
        var telefono = document.getElementById("Telefono").value;
        var nombreEmpresa = document.getElementById("nombre_empresa").value;
        var horario = document.getElementById("horario").value;
        var direccion = document.getElementById("direccion_empresa").value;
        var descripcion = document.getElementById("descripcion").value;

        if (infoPersona === "" || email === "" || telefono === "" || nombreEmpresa === "" || horario === "" || direccion === "" || descripcion === "") {
            alert("Por favor, complete todos los campos.");
            return false; // Evita que se envíe el formulario si hay campos vacíos
        }

        // Aquí puedes agregar más validaciones según tus necesidades, como validar el formato del correo electrónico, número de teléfono, etc.

        return true; // Envía el formulario si todos los campos están llenos
    }
</script>-->

    </div>
    <footer>
    <?php
    include_once('codigos/footer.inc');
    ?>
    </footer>
    <script src="js/index.js"></script>
</body>
</html>
