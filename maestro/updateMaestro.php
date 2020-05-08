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
         $id_docente=$objArray['id_doc']; 
        $nomdocente=$objArray['nom_docente'];
        $pass=$objArray['password'];
        $result = mysqli_query($Cn,"UPDATE docente SET nom_docente='$nomdocente',password='$pass' WHERE id_doc='$id_docente'");
        if ($result) {   
            $response["success"] = 200;   // El success=200 es que encontro eñ producto
            $response["message"] = "Docente Actualizado";
            // codifica la información en formato de JSON response
            echo json_encode($response);
        } else {
                $response["success"] = 406;  
                $response["message"] = "El Docente no se actualizo";
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
