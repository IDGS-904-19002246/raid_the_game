<?php
function conectarDB($ip, $user, $pass, $db)
{
    $mysqli = new mysqli($ip, $user, $pass, $db);
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}
$conn = conectarDB("104.254.245.234", "adcontrol", '491n$iuZ1', "scontrol2019");

$suggestions = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['query'])) {
        $search = $_GET['query'];
        $sql = "SELECT
                g.gid,
                p.pnombre,
                CONCAT(hd.hodesc ,' de ',hh.hohdesc) horario
                
            FROM dwork_empresa_grupos g
            INNER JOIN dwork_empresa_productos p ON g.pid = p.pid
            INNER JOIN dwork_horarios_dias hd ON hd.hoid= g.hoid
            INNER JOIN dwork_horarios_horas hh ON hh.hohid= g.hohid
            WHERE
            g.gid LIKE '%{$search}%' OR p.pnombre LIKE '%{$search}%'";
        $result = $conn->query($sql);

        // $stmt = $conn->prepare("SELECT email FROM tbl_puntajes WHERE email LIKE ?");
        // $likeSearch = "%" . $search . "%";
        // $stmt->bind_param("s", $likeSearch);
        // $stmt->execute();
        // $result = $stmt->get_result();

        if ($result) {
            // OPCION 1
            // while ($row = $result->fetch_assoc()) {
            //     $suggestions[] = $row['email'];
            // }
            // OPCION 2
            // $rows = $result->fetch_all(MYSQLI_ASSOC);
            // $suggestions = array_column($rows, 'email');
            // OPCION 3
            $suggestions = $result->fetch_all(MYSQLI_ASSOC);
            // OPCION 4
            // $suggestions = array_column($result->fetch_all(MYSQLI_ASSOC),'email');
        }
        
    }


}


echo json_encode($suggestions);
?>