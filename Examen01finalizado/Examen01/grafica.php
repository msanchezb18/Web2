<!DOCTYPE html>
<html lang="en">
<head>	
    <?php
        include_once("segmentos/encabe.inc");        
	?>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   
    <script type="text/javascript">
        var datos = $.ajax({
            url: 'datosMF.php',
            type: 'post',
            dataType: 'json',
            async: false
        }).responseText;
        console.log(datos);
        datos = JSON.parse(datos);
        for (var i = 0; i < datos.length; i++) {
            datos[i][1] = parseFloat(datos[i][1]);
            datos[i][2] = parseFloat(datos[i][2]);
        }
        google.load("visualization", "1", { packages: ["corechart"] });

        google.setOnLoadCallback(creaGrafico);

        function creaGrafico() {
            // Crea un objeto DataTable y define las columnas
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Entrenamiento');
            data.addColumn('number', 'Edades (%)');
            data.addColumn('number', 'Ingresos (%)');

            // Agrega los datos desde la matriz JSON
            data.addRows(datos);

            var opciones = {
                title: 'Valores absolutos de los archivos',
                hAxis: { title: 'Valores', titleTextStyle: { color: 'green' } },
                vAxis: { title: 'Porcentaje', titleTextStyle: { color: '#FF0000' } },
                backgroundColor: '#ffffcc',
                legend: { position: 'bottom', textStyle: { color: 'blue', fontSize: 13 } },
                width: 900,
                height: 500
            };

            var grafico = new google.visualization.ColumnChart(document.getElementById('grafica'));
            grafico.draw(data, opciones);
        }
    </script>   
</head>
<body class="container">
    <header class="row">
        <?php
            include_once("segmentos/menu.inc");
        ?>
    </header>

    <main class="row">
        <div class="linea_sep">
            <div id="grafica"></div>
        </div>
    </main>

    <footer class="row pie">
        <?php
            include_once("segmentos/pie.inc");
        ?>
    </footer>

    <!-- jQuery necesario para los efectos de bootstrap -->
    <script src="formatos/bootstrap/js/jquery-1.11.3.min.js"></script>
    <script src="formatos/bootstrap/js/bootstrap.js"></script>
</body>
</html>