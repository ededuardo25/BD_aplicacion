
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
         $id_grupo=$objArray['id_grupo']; 
         $grupo=$objArray['grupo'];
         $nocontrol=$objArray['nocontrol'];
         $materiaid=$objArray['materiaid'];
         $docenteid=$objArray['docenteid'];
        $result = mysqli_query($Cn,"UPDATE grupo SET grupo='$grupo',nocontrol='$nocontrol',materiaid='$materiaid',docenteid='$docenteid' WHERE id_grupo='$id_grupo'");
        if ($result) {   
            $response["success"] = 200;   // El success=200 es que encontro eñ producto
            $response["message"] = "Grupo Actualizado";
            // codifica la información en formato de JSON response
            echo json_encode($response);
        } else {
                $response["success"] = 406;  
                $response["message"] = "El Grupo no se actualizo";
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
