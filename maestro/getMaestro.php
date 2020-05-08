<?php
$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
// Checa que le esté llegando por el método POST el idProd
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    $id_docente=$objArray['id_doc'];
    $result = mysqli_query($Cn,"SELECT id_doc,nom_docente,password from docente WHERE id_doc = '$id_docente'");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
           	$docente = array();

            $docente["id_doc"] = $result["id_doc"];
                $docente["nom_docente"] = $result["nom_docente"];
                $docente["password"]=$result["password"];
   
           $response["success"] = 200;   // El success=200 es que encontro el producto
           $response["message"] = "Docente encontrado";
           $response["docente"] = array();

           array_push($response["docente"], $docente);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el producto
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
