<!DOCTYPE html>
<html lang="en">
  
  <head>
  <?php
  //include_once '../Proyecto/Configuración/config.php';

 // $sql = "SELECT * FROM PYME";
 // $result = $conn->query($sql);

  include_once('codigos/enca.inc');
  ?>
  </head>
  <body>
    
  <header> 
  <?php
  include_once('codigos/nav.inc');
  ?>
  </header>
    <BR></BR>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <section class="container1">
        <div class="slider-wrapper">
          <div class="slider">
            <img src="img/estetica.jpg" alt="" id="slide-1" />
            <img src="img/lavacar.jpg" alt="" id="slide-2" />
            <img src="img/manicura.jpg" alt="" id="slide-3" />
            <img src="img/pasteleria.jpg" alt="" id="slide-4" />
          </div>
          <div class="slider-nav">
            <a href="#slide-1"></a>
            <a href="#slide-2"></a>
            <a href="#slide-3"></a>
            <a href="#slide-4"></a>
          </div>
        </div>
      </section>
    </div>
    <section class="container2">
    <h1><strong>MARKETIG CR</strong></h1>
    <?php
    if ($result->num_rows > 0) { 
        echo "<div class='gallery'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='content'>";  
            echo "<img src='img/lavacar.jpg' alt=''>";
            echo "<h3>" . $row['nombre_empresa'] . "</h3>";
            echo "<p>" . $row['descripcion'] . "</p>";
            echo "<a href='Paginainfo.php?detalle=" . $row['id'] . "'><button class='adopt-2'>Leer Más</button></a>";   
            echo "</div>";
        }
        echo "</div>";
    }
    ?>
 
  </section>
  <footer>
  <?php
  include_once('codigos/footer.inc');
  ?>
  </footer>
  </body>
</html>
