<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = mysqli_query($Cn,"SELECT id_materia,nom_materia FROM materia ORDER BY nom_materia");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;   // El success=200 es que encontro el producto
            $response["message"] = "Materias encontradas";
            $response["materias"] = array();
            while ($res = mysqli_fetch_array($result)){
                $materia = array();
                $materia["id_materia"] = $res["id_materia"];
                $materia["nom_materia"] = $res["nom_materia"];
                array_push($response["materias"], $materia);
            }
           echo json_encode($response);
        } else {
            // No Encontro al alumno
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Materia no encontrada";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Materia no encontrada";
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
