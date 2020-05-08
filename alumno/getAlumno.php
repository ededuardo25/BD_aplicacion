<?php
$response = array();
$Cn = mysqli_connect("localhost","root","","escuela")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
// Checa que le esté llegando por el método POST el idProd
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    $nocontrol=$objArray['no_control'];
    $result = mysqli_query($Cn,"SELECT no_control,nom_alumno,semestre,password from alumno WHERE no_control = $nocontrol");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
           	$alumno = array();

            $alumno["no_control"] = $result["no_control"];
                $alumno["nom_alumno"] = $result["nom_alumno"];
                $alumno["semestre"] = $result["semestre"];
                $alumno["password"]=$result["password"];
   
           $response["success"] = 200;   // El success=200 es que encontro el producto
           $response["message"] = "Alumno encontrado";
           $response["alumno"] = array();

           array_push($response["alumno"], $alumno);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el producto
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Producto no encontrado";
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
