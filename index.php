<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title></title>
</head>
<body>
<h1>Leer Archivo Excel</h1>

<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post">
    Seleccionar el archivos excel: <input type="file" name="archivo"><br><br>
    <button type="submit" name="button">Enviar</button>
</form>

<?php

if(isset($_POST["button"])){

    require_once 'PHPExcel/Classes/PHPExcel.php';

   
    $archivo = $_POST["archivo"];
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0); 

    $highestRow = $sheet->getHighestRow(); 

    $highestColumn = $sheet->getHighestColumn();
    
    $carpeta_raiz="UPG.CARPETAS.ESTUDIANTES";
    $ruta="C:/xampp/htdocs/taller/"; 
    
    $crear_directorio=$ruta.$carpeta_raiz;
    if(!is_dir($crear_directorio)){
        mkdir($crear_directorio,0777,true);
        echo 'Se creo la carpeta raiz:UPG.CARPETAS.ESTUDIANTES <br><br>';        
    }
    
            
        for ($row = 2; $row <= $highestRow; $row++){
            $desc_especialidad=trim($sheet->getCell("F".$row)->getValue());
            $ruta_especialidad=$crear_directorio.'/'.$desc_especialidad;
            if(!is_dir($ruta_especialidad)){
                mkdir($ruta_especialidad,0777,true); 
                echo 'Se creo la carpeta especialidad :'.$desc_especialidad.'<br><br>';
                
            }
            
            $anio_ingreso=trim($sheet->getCell("E".$row)->getValue());
            $ruta_ingreso=$ruta_especialidad.'/'.$anio_ingreso;
            if(!is_dir($ruta_ingreso)){
                mkdir($ruta_ingreso,0777,true); 
            echo 'Se creo la carpeta año de ingreso :'.$anio_ingreso.'<br><br>';
            }
           
        
            $nom_alumno=trim($sheet->getCell("D".$row)->getValue());
            $ape_materno=trim($sheet->getCell("C".$row)->getValue());
            $ape_paterno=trim($sheet->getCell("B".$row)->getValue());
            $cod_alumno=trim($sheet->getCell("A".$row)->getValue());
            $ruta_alumno=$ruta_ingreso.'/'.$cod_alumno.'-'.$ape_paterno.'.'.$ape_materno.'.'.$nom_alumno;
            mkdir($ruta_alumno,0777,true); 
            echo 'Se creo la carpeta del alumno:'.$cod_alumno.'-'.$ape_paterno.'.'.$ape_materno.'.'.$nom_alumno.'<br><br>';
        }
   
}

/*
Crear un programa en java o cualquier otro lenguaje, que lea un archivo segun la estructura del archivo adjunto y cree carpetas para cada estudiante
Ejemplo:
UPG.CARPETAS.ESTUDIANTES
PROGRAMA
PERIODO
CODIGOALUMNO-APATERNO.AMATERNO.NOMBRES
CODIGOALUMNO-APATERNO.AMATERNO.NOMBRES

*/
    
?>
</body>
</html>



