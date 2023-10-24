<?php

    $proceso = false;
    if(isset($_POST["oc_Control"])){
        //Primer archivo
        $archivo1 = $_FILES["txtArchi1"]["tmp_name"];
        $tamanio1 = $_FILES["txtArchi1"]["size"];
        $tipo1 = $_FILES["txtArchi1"]["type"];
        $nombre1 = $_FILES["txtArchi1"]["name"];

        //Segundo archivo
        $archivo2 = $_FILES["txtArchi2"]["tmp_name"];
        $tamanio2 = $_FILES["txtArchi2"]["size"];
        $tipo2 = $_FILES["txtArchi2"]["type"];
        $nombre2 = $_FILES["txtArchi2"]["name"];

        //valida que
        if ($tamanio1 > 0 && $tamanio2 > 0) {
            //procesa el contenido del archivo recibido.
            $archi1 = fopen($archivo1, "rb");
            $archi2 = fopen($archivo2, "rb");

            if(isset($_POST["txt_Control_C"])){
                //se asigna el valor capturado a la variable $controlCharacter
                $controlCharacter = $_POST["txt_Control_C"];
            } else {
                echo "no se asignó ningún valor";
            }
            //se asigna el valor en la posición correspondiente
            $encabezados1 = explode($controlCharacter,fgets($archi1));
            $encabezados2 = explode($controlCharacter,fgets($archi2));

            $contenido1 = array();
            $contenido2 = array();
            $posi1 = 0;
            $posi2 = 0;
            while($linea = fgets($archi1)){
                $contenido1[$posi1++] = explode($controlCharacter, $linea);
            }
            while($linea = fgets($archi2)){
                $contenido2[$posi2++] = explode($controlCharacter, $linea);
            }
            
            //cierra el archivo.
            fclose($archi1);
            fclose($archi2);

            $proceso = true;

            //verifica si el archivo tiene encabezado.
            if(isset($_POST["txtEncabezado"]) && $_POST["txtEncabezado"] == "on") {
                //mantiene el comportamiento de la primera línea tal y como lo hace.
            } else {
                //crea sus propios encabezados para cada campo, cuando el archivo no posee los mismos.
                $encabezados1 = array_keys($contenido1[0]);
            }
   

            if(isset($_POST["txtEncabezado"]) && $_POST["txtEncabezado"] == "on") {
            } else {
                $encabezados2 = array_keys($contenido2[0]);
            }
        }
    }

    function contarFilas($archivo1, $archivo2) {
        $contador1 = 0;
        $contador2 = 0;
    
        // Contar filas en el primer archivo
        if ($archivo1) {
            $lineas1 = file($archivo1);
            $contador1 = count($lineas1);
        }
    
        // Contar filas en el segundo archivo
        if ($archivo2) {
            $lineas2 = file($archivo2);
            $contador2 = count($lineas2);
        }
    
        return array('archivo1' => $contador1, 'archivo2' => $contador2);
    }
    
       
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include_once("segmentos/encabe.inc");
	?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Proceso de datos</title>
    <script type=""></script>
</head>
<body class="container">
	<header class="row">
		<?php
			include_once("segmentos/menu.inc");
		?>
	</header>

	<main class="row">
		<div class="linea_sep">
            <h3>Procesando archivo.</h3>
            <br>
            <?php
                //Punto 2
                echo "<h1>Punto 2</h1>";
                if(!$proceso){
                    //En caso que el archivo .csv no pudiese ser procesado
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '  El archivo no puede ser procesado, verifique sus datos.....!';
                    echo '</div>';
                }else{
                    //En caso que el archivo .csv pudiese ser procesado
                    echo "<h4>Datos Generales.</h4>";
                    $resultado = contarFilas($archivo1, $archivo2);
                    echo "<table class='table table-bordered table-hover'>";
                    echo "  <tr>";
                    echo "      <td>Nombre</td><td>Tipo</td><td>Tamaño</td><td>observaciones</td>";
                    echo "  </tr>";
                    echo "      <td>".$nombre1."</td><td>".$tipo1."</td><td>".number_format((($tamanio1)/1024)/1024,2,'.',',')." MBs</td><td>". $resultado['archivo1']."</td>";
                    echo "</table>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "  <tr>";
                    echo "      <td>Nombre</td><td>Tipo</td><td>Tamaño</td><td>observaciones</td>";
                    echo "  </tr>";
                    echo "      <td>".$nombre2."</td><td>".$tipo2."</td><td>".number_format((($tamanio2)/1024)/1024,2,'.',',')." MBs</td><td>". $resultado['archivo2']."</td>";
                    echo "</table>";

                    echo "<br>";
                    echo "<h4>Estructura.</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "  <tr>";
                }
               
                    //Punto 3
                    echo "<h1>Punto 3</h1>";
                    function determinarTipoDato($valor) {
                        if (is_numeric($valor)) {
                            if (strpos($valor, '.') !== false || strpos($valor, ',') !== false) {
                                return "float";
                            } else {
                                if (ctype_digit(str_replace(['-', '+'], '', $valor))) {
                                    return "int";
                                }
                            }
                        } elseif (DateTime::createFromFormat('d/m/Y', $valor) !== false) {
                            return "date";
                        } elseif (strlen($valor) === 1) {
                            return "char";
                        }
                        return "string";
                    }
                    
                    function determinarUso($valor) {
                        if (preg_match('/[a-zA-Z$@#%_]/', $valor)) {
                            return "cualitativo";
                        }
                        return "cuantitativo";
                    }
                    
                    echo "<tr>";
                    echo "<td>Campo</td><td>Tipo</td><td>Uso</td><td>Valor</td>";
                    echo "</tr>";

                    $CampoContenido1 = 1;
                    $camposImpresos1 = array();

                    foreach ($contenido1 as $fila) {
                        $camposImpresosEnFila1 = array();

                        foreach ($fila as $index => $dato) {
                            if (!in_array($index, $camposImpresos1) && !in_array($index, $camposImpresosEnFila1)) {
                                $tipo = determinarTipoDato($dato);
                                $uso = determinarUso($dato);

                                echo "<td>Campo $CampoContenido1</td><td>$tipo</td><td>$uso</td><td>";

                                $valoresCampo1 = array();
                                foreach ($contenido1 as $fila) {
                                    $valor = str_replace(',', '.', $fila[$index]);
                                    $valoresCampo1[] = $valor;
                                }

                                $valoresEnteros1 = array_filter($valoresCampo1, 'is_numeric');
                                if (!empty($valoresEnteros1) && $tipo == "int") {
                                    echo min($valoresEnteros1) . " al " . max($valoresEnteros1);
                                } else {
                                    echo "variado";
                                }

                                $camposImpresos1[] = $index;
                                $camposImpresosEnFila1[] = $index;

                                echo "</td>";
                                $CampoContenido1++;
                            }
                            echo "</tr>";
                        }
                    }

                    echo "</table>";

                    // Adicional
                    echo "<br>";
                    echo "<h4>Datos.</h4>";
                    echo "<table id='tblDatos' class='table table-bordered table-hover'>";
                    echo "<thead><tr>";

                    foreach ($encabezados1 as $titulo) {
                        echo "<td>" . $titulo . "</td>";
                    }

                    echo "</tr></thead><tbody>";

                    for ($i = 0; $i < 100; $i++) {
                        echo "<tr>";
                        foreach ($contenido1[$i] as $datos) {
                            echo "<td>" . $datos . "</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "<br>";


                    //Punto 4
                    $edades = array();   
                    $ingresos = array(); 
                    foreach ($contenido1 as $fila) {
                        $edad = $fila[3];
                        $ingreso = $fila[5];
                    
                        if ($edad > 0) {
                            $edades[] = $edad;
                        }
                    
                        if ($ingreso > 0) {
                            $ingresos[] = $ingreso;
                        }
                    }
                    
                    echo "<br>";
                    echo "<h1>Punto 4</h1>";
                    function calcularFrecuencias($valores) {
                        $frecuencias = array();
                        $min = min($valores);
                        $max = max($valores);
                        $intervalo = ($max - $min) / 5; 

                        for ($i = 0; $i < 5; $i++) {
                            $inicio = $min + ($i * $intervalo);
                            $fin = $inicio + $intervalo;
                            $frecuencia = 0;

                            foreach ($valores as $valor) {
                                if ($valor >= $inicio && $valor < $fin) {
                                    $frecuencia++;
                                }
                            }

                            $frecuencias[] = [
                                'Intervalo' => "$inicio - $fin",
                                'Frecuencia Absoluta' => $frecuencia,
                                'Frecuencia Porcentual' => ($frecuencia / count($valores)) * 100
                            ];
                        }

                        return $frecuencias;
                    }

                    $frecuenciasEdades = calcularFrecuencias($edades);
                    $frecuenciasIngresos = calcularFrecuencias($ingresos);

                    echo "<h4>Edades</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr><th>Intervalo</th><th>Frecuencia Absoluta</th><th>Frecuencia Porcentual</th></tr>";

                    foreach ($frecuenciasEdades as $filaTabla) {
                        echo "<tr>";
                        echo "<td>" . $filaTabla['Intervalo'] . "</td>";
                        echo "<td>" . $filaTabla['Frecuencia Absoluta'] . "</td>";
                        echo "<td>" . $filaTabla['Frecuencia Porcentual'] . "%</td>";
                        echo "</tr>";
                    }

                    echo "</table>";

                    echo "<h4>Ingresos</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr><th>Intervalo</th><th>Frecuencia Absoluta</th><th>Frecuencia Porcentual</th></tr>";

                    foreach ($frecuenciasIngresos as $filaTabla) {
                        echo "<tr>";
                        echo "<td>" . $filaTabla['Intervalo'] . "</td>";
                        echo "<td>" . $filaTabla['Frecuencia Absoluta'] . "</td>";
                        echo "<td>" . $filaTabla['Frecuencia Porcentual'] . "%</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                

                    //Punto 5
                    $edades5 = array();   
                    $ingresos5 = array(); 
                    foreach ($contenido2 as $fila5) {
                        $edad5 = $fila5[3];
                        $ingreso5 = $fila5[5];
                    
                        if ($edad5 > 0) {
                            $edades5[] = $edad5;
                        }
                    
                        if ($ingreso5 > 0) {
                            $ingresos5[] = $ingreso5;
                        }
                    }
                    
                    echo "<br>";
                    echo "<h1>Punto 5</h1>";
                    function calcularFrecuencias5($valores5) {
                        $frecuencias5 = array();
                        $min = min($valores5);
                        $max = max($valores5);
                        $intervalo = ($max - $min) / 5; 

                        for ($i = 0; $i < 5; $i++) {
                            $inicio = $min + ($i * $intervalo);
                            $fin = $inicio + $intervalo;
                            $frecuencia5 = 0;

                            foreach ($valores5 as $valor) {
                                if ($valor >= $inicio && $valor < $fin) {
                                    $frecuencia5++;
                                }
                            }

                            $frecuencias5[] = [
                                'Intervalo' => "$inicio - $fin",
                                'Frecuencia Absoluta' => $frecuencia5,
                                'Frecuencia Porcentual' => ($frecuencia5 / count($valores5)) * 100
                            ];
                        }

                        return $frecuencias5;
                    }
                    
                    
                    $frecuenciasEdades5 = calcularFrecuencias($edades5);
                    $frecuenciasIngresos5 = calcularFrecuencias($ingresos5);
                    echo "<h4>Edades</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr><th>Intervalo</th><th>Frecuencia Absoluta</th><th>Frecuencia Porcentual</th></tr>";

                    foreach ($frecuenciasEdades5 as $filaTabla5) {
                        echo "<tr>";
                        echo "<td>" . $filaTabla5['Intervalo'] . "</td>";
                        echo "<td>" . $filaTabla5['Frecuencia Absoluta'] . "</td>";
                        echo "<td>" . $filaTabla5['Frecuencia Porcentual'] . "%</td>";
                        echo "</tr>";
                    }

                    echo "</table>";

                    echo "<h4>Ingresos</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr><th>Intervalo</th><th>Frecuencia Absoluta</th><th>Frecuencia Porcentual</th></tr>";

                    foreach ($frecuenciasIngresos5 as $filaTabla5) {
                        echo "<tr>";
                        echo "<td>" . $filaTabla5['Intervalo'] . "</td>";
                        echo "<td>" . $filaTabla5['Frecuencia Absoluta'] . "</td>";
                        echo "<td>" . $filaTabla5['Frecuencia Porcentual'] . "%</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    echo "<br>";
                    echo "<h1>Punto 6</h1>";
                    echo "<br>";
                    echo "<br>";
                    echo "<br>";
                    echo $nombre1;
                    echo"<div>";
                    echo '
                    <div>
                    <div id="chart_divedad1" class="col-md-6"></div>
                    <div id="chart_divingreso1" class="col-md-6"></div>
                    </div>
                    ';

                    echo "<br>";
                    echo "<br>";
                    echo "<br>";
                    echo $nombre2;
                    echo '
                    <div>
                    <div id="chart_divedad2" class="col-md-6"></div>
                    <div id="chart_divingreso2" class="col-md-6"></div>
                    </div>
                    ';
                    echo"</div>";

                    $edadFrecuencias1 = [['Edad', 'Frecuencia Absoluta']];
                    $ingresoFrecuencias1 = [['Ingreso', 'Frecuencia Absoluta']];
                    $edadFrecuencias2 = [['Edad', 'Frecuencia Absoluta']];
                    $ingresoFrecuencias2 = [['Ingreso', 'Frecuencia Absoluta']];

                    foreach ($frecuenciasEdades as $fila) {
                        $edadFrecuencias1[] = [$fila['Intervalo'], $fila['Frecuencia Absoluta']];
                    }
                    
                    foreach ($frecuenciasIngresos as $fila) {
                        $ingresoFrecuencias1[] = [$fila['Intervalo'], $fila['Frecuencia Absoluta']];
                    }
                    

                    foreach ($frecuenciasEdades5 as $fila) {
                        $edadFrecuencias2[] = [$fila['Intervalo'], $fila['Frecuencia Absoluta']];
                    }
                    
                    foreach ($frecuenciasIngresos5 as $fila) {
                        $ingresoFrecuencias2[] = [$fila['Intervalo'], $fila['Frecuencia Absoluta']];
                    }
                    
                    ?>
            <br>
            <h1>Punto 7</h1>
            <div class="linea_sep acomodarestilo">
                <h3 class="acomodarestilo" style="color:black">Criterio del grupo:</h3>
                <h3 class="acomodarestilo" style="color: black">
                    En el punto 7, se analizan los resultados obtenidos a partir de los gráficos generados a partir de los datos de los archivos <?php echo $nombre1; ?> y <?php echo $nombre2; ?>.

                    <h4>Distribución de Edad:</h4>
                    Los gráficos de distribución de edad muestran cómo se distribuyen las edades en los dos conjuntos de datos. En el archivo <?php echo $nombre1; ?>, los datos parecen seguir una distribución uniforme, lo que sugiere una variabilidad en las edades. Por otro lado, en <?php echo $nombre2; ?>, la distribución de edad muestra un pico en ciertos grupos de edad, lo que indica una concentración de datos en esas edades específicas.

                    <h4>Distribución de Ingresos:</h4>
                    Los gráficos de distribución de ingresos muestran cómo se distribuyen los ingresos en ambos archivos. En <?php echo $nombre1; ?>, los ingresos parecen ser bastante uniformes, lo que indica que los datos no presentan concentraciones significativas. En cambio, <?php echo $nombre2; ?> muestra una distribución de ingresos con varios picos, lo que sugiere que ciertos grupos de ingresos son más comunes que otros.

                    Estas diferencias en las distribuciones pueden deberse a la naturaleza de los datos en cada archivo. Es importante considerar la calidad y la representatividad de los datos al interpretar estas distribuciones.

                    En resumen, los gráficos de distribución de edad y de ingresos revelan diferencias significativas entre <?php echo $nombre1; ?> y <?php echo $nombre2; ?>. Estas diferencias pueden influir en el análisis y deben ser tenidas en cuenta al interpretar los resultados.

                </h3>
            </div>
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
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblDatos').dataTable({
                "language":{
                    "url": "dataTables.Spanish.lang"
                }
            });
        });
    </script>
    <script type="text/javascript">
        google.load("visualization", "1", { packages: ["corechart"] });
        google.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Chart data for Age
            var dataEdad1 = google.visualization.arrayToDataTable(<?php echo json_encode($edadFrecuencias1); ?>);
            var dataEdad2 = google.visualization.arrayToDataTable(<?php echo json_encode($edadFrecuencias2); ?>);

            // Chart options
            var options = {
                title: "Edad Frecuencia",
                hAxis: { title: "Edad" },
                vAxis: { title: "Frecuencia Absoluta" },
                height: 590,
                width: 700,
                title: 'Distribución de Edad',
                pieHole: 0, // Agujero en el medio (0 para un círculo completo)
            };

            // Create and draw the Age charts
            var chartEdad1 = new google.visualization.PieChart(document.getElementById('chart_divedad1'));
            chartEdad1.draw(dataEdad1, options);

            var chartEdad2 = new google.visualization.PieChart(document.getElementById('chart_divedad2'));
            chartEdad2.draw(dataEdad2, options);

            // Chart data for Income
            var dataIngreso1 = google.visualization.arrayToDataTable(<?php echo json_encode($ingresoFrecuencias1); ?>);
            var dataIngreso2 = google.visualization.arrayToDataTable(<?php echo json_encode($ingresoFrecuencias2); ?>);

            // Chart options
            var options = {
                title: "Ingreso Frecuencia",
                hAxis: { title: "Ingreso" },
                vAxis: { title: "Frecuencia Absoluta" },
                width: 700,
                height: 590,
                title: 'Distribución de Ingresos',
                pieHole: 0, // Agujero en el medio (0 para un círculo completo)
            };

            // Create and draw the Income charts
            var chartIngreso1 = new google.visualization.PieChart(document.getElementById('chart_divingreso1'));
            chartIngreso1.draw(dataIngreso1, options);

            var chartIngreso2 = new google.visualization.PieChart(document.getElementById('chart_divingreso2'));
            chartIngreso2.draw(dataIngreso2, options);
        }
    </script>

    

</body>
</html>