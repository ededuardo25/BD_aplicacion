<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = mysqli_query($Cn,"SELECT id_mensaje,Emisor,Receptor,Mensaje FROM mensajes ORDER BY Emisor");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;   // El success=200 es que encontro el producto
            $response["message"] = "Mensajes Encontrados";
            $response["mensajes"] = array();
            while ($res = mysqli_fetch_array($result)){
                $mensajes = array();
                $mensajes["id_mensaje"] = $res["id_mensaje"];
                $mensajes["Emisor"] = $res["Emisor"];
                $mensajes["Receptor"] = $res["Receptor"];
                $mensajes["Mensaje"] = $res["Mensaje"];
                array_push($response["mensajes"], $mensajes);
            }
           echo json_encode($response);
        } else {
            // No Encontro al alumno
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Mensaje no encontrado";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Mensaje no encontrada";
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
