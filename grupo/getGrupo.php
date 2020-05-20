<?php
$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
// Checa que le esté llegando por el método POST el idProd
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    $id_grupo=$objArray['id_grupo'];
    $result = mysqli_query($Cn,"SELECT id_grupo,grupo,nocontrol,materiaid,docenteid from grupo WHERE id_grupo = '$id_grupo'");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
           	$grupo = array();

            $grupo["id_grupo"] = $result["id_grupo"];
            $grupo["grupo"] = $result["grupo"];
            $grupo["nocontrol"] = $result["nocontrol"];
            $grupo["materiaid"] = $result["materiaid"];
            $grupo["docenteid"] = $result["docenteid"];

           $response["success"] = 200;   // El success=200 es que encontro el producto
           $response["message"] = "Grupo encontrado";
           $response["grupo"] = array();

           array_push($response["grupo"], $grupo);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el producto
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Grupo no encontrada";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Grupo no encontrada";
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
