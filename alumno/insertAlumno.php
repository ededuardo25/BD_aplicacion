<?php

$response = array();

$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $response["success"] = 400;
        $response["message"] = "Faltan Datos entrada";
        echo json_encode($response);
    }
    else{
        $nocontrol=$objArray['no_control']; 
        $nomalumno=$objArray['nom_alumno'];
        $sem=$objArray['semestre'];
        $pass=$objArray['password'];

        $result = mysqli_query($Cn,"INSERT INTO alumno(no_control,nom_alumno,semestre,password) values 
        ('$nocontrol','$nomalumno',$sem,'$pass')");

        if ($result) {   
            $response["success"] = 200;   // El success=200 es que encontro eñ producto
            $response["message"] = "Alumno Insertado";
            // codifica la información en formato de JSON response
            echo json_encode($response);
        } else {
                $response["success"] = 406;  
                $response["message"] = "Alumno no Insertado";
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>
