<?php
$archivo = 'webhoo.txt';
$text_origin = file_get_contents($archivo);

$final = urldecode($text_origin);
$text_ = str_replace("&", ",<br>", $final);

// echo ''.$text_;

// if ($contenido !== false) {
//     echo "Contenido del archivo: <br>";
//     echo $contenido;
// } else {
//     echo "Error al leer el archivo.";
// }


$texto = "account[subdomain]=auladisermx,
account[id]=32067039,
account[_links][self]=https://auladisermx.amocrm.com,
leads[update][0][id]=9104918,
leads[update][0][name]=Prueba Tony,
leads[update][0][status_id]=69298611,
leads[update][0][old_status_id]=69298647";

// Dividir el texto en líneas
$lineas = explode("\n", $texto);

// Inicializar un arreglo para almacenar los datos
$datos = array();

// Recorrer cada línea del texto
foreach ($lineas as $linea) {
    // Dividir la línea en la clave y el valor
    list($clave, $valor) = explode("=", $linea, 2);

    // Eliminar espacios en blanco
    $clave = trim($clave);
    $valor = trim($valor);

    // Convertir el valor a la forma adecuada
    $valor = str_replace(array('[', ']'), '', $valor);

    // Dividir la clave en partes
    $partes = explode('[', $clave);
    $actual = &$datos;

    // Recorrer cada parte de la clave
    foreach ($partes as $parte) {
        $parte = rtrim($parte, ']');

        // Crear el arreglo asociativo si no existe
        if (!isset($actual[$parte])) {
            $actual[$parte] = array();
        }

        // Cambiar el puntero al siguiente nivel
        $actual = &$actual[$parte];
    }

    // Asignar el valor a la clave final
    $actual = $valor;
}

// Convertir el arreglo asociativo en JSON
$json = json_encode($datos, JSON_PRETTY_PRINT);

// Mostrar el JSON resultante
echo $json;
?>