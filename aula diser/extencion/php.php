
<?php
header('Content-Type: application/json');

// Recibir el JSON y convertirlo a un array
$data = json_decode(file_get_contents('php://input'), true);

// Aquí podrías hacer cualquier procesamiento adicional si es necesario

// Para este ejemplo, simplemente creamos una respuesta
$response = [
    [
        'name' => $data['name'],
        'age' => $data['age']
    ]
];

// Enviamos la respuesta como JSON
echo json_encode($response);
?>
