<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = mysqli_query($Cn,"SELECT id_doc,nom_docente,password FROM docente ORDER BY nom_docente");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;   // El success=200 es que encontro el producto
            $response["message"] = "Docentes encontrados";
            $response["docentes"] = array();
            while ($res = mysqli_fetch_array($result)){
                $docente = array();
                $docente["id_doc"] = $res["id_doc"];
                $docente["nom_docente"] = $res["nom_docente"];
                $docente["password"]=$res["password"];
                array_push($response["docentes"], $docente);
            }
           echo json_encode($response);
        } else {
            // No Encontro al alumno
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Docente no encontrado";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Docente no encontrado";
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
