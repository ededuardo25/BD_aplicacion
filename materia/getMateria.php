<?php
$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
// Checa que le esté llegando por el método POST el idProd
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    $idmateria=$objArray['id_materia'];
    $result = mysqli_query($Cn,"SELECT id_materia,nom_materia from materia WHERE id_materia = '$idmateria'");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
           	$materia = array();

            $materia["id_doc"] = $result["id_materia"];
                $materia["nom_docente"] = $result["nom_materia"];
   
           $response["success"] = 200;   // El success=200 es que encontro el producto
           $response["message"] = "Materia encontrada";
           $response["materia"] = array();

           array_push($response["materia"], $materia);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el producto
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
