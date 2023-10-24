<?php
     $entrenamiento = array("Agrupacion por edades e ingresos","Edades","Ingresos");
     $sug = array("Entrenamiento", "Edades (%)", "Ingresos (%)");
     //Tengo que abrir el archivo:
     $M = 0; $F = 0;
     $archivo = fopen("CSV/CensoNacional_Entrenamiento.csv", "rb");
     $encabezado = explode("&", fgets($archivo));
     $contenido =[];
     $posi = 0;
     while($linea = fgets($archivo)){
        $buscador = $entrenamiento[1];
        $contenido[0] = explode("&", $linea);
        if ($contenido[0][6] === $buscador) { 
            if ($contenido[0][2] === "M") {
                $M++; 
            } else {
                $F++;
            }
        }
     }
     $total = $M + $F;
     $prM = number_format(($M / $total) * 100, 2);
     $prF = number_format(($F / $total) * 100, 2);
     $Edades = array($buscador, $prF, $prM);
     $M = 0; $F = 0;
     fclose($archivo);
     $archivo = fopen("CSV/CensoNacional_Entrenamiento.csv", "rb");
     $posi = 0;
     while($linea = fgets($archivo)){
        $buscador = $entrenamiento[2];
        $contenido[0] = explode("&", $linea);
        if ($contenido[0][6] === $buscador) { 
            if ($contenido[0][2] === "M") {
                $M++; 
            } else {
                $F++;
            }
        }
     }
     $total = $M + $F;
     $prM = number_format(($M / $total) * 100, 2);
     $prF = number_format(($F / $total) * 100, 2);
     $Ingresos = array($buscador, $prF, $prM);
     $M = 0; $F = 0;


     fclose($archivo);
     $archivo = fopen("CSV/CensoNacional_Entrenamiento.csv", "rb");
     $posi = 0;
     while($linea = fgets($archivo)){
        $buscador = $provincias[3];
        $contenido[0] = explode(";", $linea);
        if ($contenido[0][6] === $buscador) { 
            if ($contenido[0][2] === "M") {
                $M++; 
            } else {
                $F++;
            }
        }
     }
    
     fclose($archivo);
     echo json_encode(array($Edades, $Ingresos));
      
?>