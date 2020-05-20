<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = mysqli_query($Cn,"SELECT id_grupo,grupo,nocontrol,materiaid,docenteid FROM grupo ORDER BY nocontrol");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;   // El success=200 es que encontro el producto
            $response["message"] = "Grupos encontrados";
            $response["grupos"] = array();
            while ($res = mysqli_fetch_array($result)){
                $grupo = array();
                $grupo["id_grupo"] = $res["id_grupo"];
                $grupo["grupo"] = $res["grupo"];
                $grupo["nocontrol"] = $res["nocontrol"];
                $grupo["materiaid"] = $res["materiaid"];
                $grupo["docenteid"] = $res["docenteid"];
                array_push($response["grupos"], $grupo);
            }
           echo json_encode($response);
        } else {
            // No Encontro al alumno
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Grupo no encontrado";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Grupo no encontrado";
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
