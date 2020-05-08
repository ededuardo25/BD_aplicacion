<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = mysqli_query($Cn,"SELECT no_control,nom_alumno,semestre,password FROM alumno ORDER BY nom_alumno");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;   // El success=200 es que encontro el producto
            $response["message"] = "Alumnos encontrados";
            $response["alumnos"] = array();
            while ($res = mysqli_fetch_array($result)){
                $alumno = array();
                $alumno["no_control"] = $res["no_control"];
                $alumno["nom_alumno"] = $res["nom_alumno"];
                $alumno["semestre"] = $res["semestre"];
                $alumno["password"]=$res["password"];
                array_push($response["alumnos"], $alumno);
            }
           echo json_encode($response);
        } else {
            // No Encontro al alumno
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Alumno no encontrado";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Alumno no encontrado";
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>
