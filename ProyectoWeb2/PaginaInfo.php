<!DOCTYPE html>
<html lang="en">
  <head>
<?php //include_once '../Proyecto/Configuración/config.php';
  
  //$detalle = isset($_GET['detalle']) ? $_GET['detalle'] : 'desconocido';
  //$sql = "SELECT * FROM PYME WHERE id = " . $detalle;
  //$result = $conn->query($sql);
  
//  $row = $result->fetch_assoc();


  include_once('codigos/enca.inc');?>
  </head>
  <body>
    <header>
    <?php
  include_once('codigos/nav.inc');?>
  <style>
      table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    margin-left: auto; 
    margin-right: auto;
}

th, td {
    border-radius: 1px solid black;
    padding: 8px;
    text-align: left;
    vertical-align: middle; 
}

th {
    background-color: rgb(116, 81, 199);
    color: #fff;
}

    </style>
    </header>

    <div class="motto">
      <h2><strong>Información de Servicio</strong></h2>
    </div>
    <table>
    <td rowspan="8" class="image-cell">
        <img src="./img/estetica" alt="" id="ImageDetalle">
    </td>
    <tr>
        <th>dueño</th>
        <td><?php echo $row['informacion_personal'] ?></td>
    </tr>
    <tr>
        <th>email</th>
        <td><?php echo $row['correo_electronico'] ?></td>
    </tr>
    <tr>
        <th>Telefono</th>
        <td><?php echo $row['telefono'] ?></td>
    </tr>
    <tr>
        <th>Empresa</th>
        <td><?php echo $row['nombre_empresa'] ?></td>
    </tr>
    <tr>
        <th>Horario</th>
        <td><?php echo $row['horario'] ?></td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td><?php echo $row['direccion'] ?></td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td><?php echo $row['descripcion'] ?></td>
    </tr>
</table> 

    <section class="container4">

      <?php
         echo "<div class='gallery'>";
           echo "<div class='content'>"; 
           echo "<img src=img/lavacar.jpg' alt=''>";
           echo "<h3>" . $row['nombre_empresa'] . "</h3>";
           echo "<p>" . $row['descripcion'] . "</p>";
           echo "<button class='adopt-2'>Leer Más</button>";   
           echo "</div>";
         echo "</div>";
      ?>
    </section>
    <footer>
    <?php
  include_once('codigos/footer.inc');?>
    </footer>

  </body>
</html>