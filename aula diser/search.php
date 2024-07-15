<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_juegos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$suggestions = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['query'])) {
        $search = $_GET['query'];
        $sql = "SELECT email FROM tbl_puntajes WHERE email LIKE '%{$search}%'";
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
            // $suggestions = $result->fetch_all(MYSQLI_ASSOC);
            // OPCION 4
            $suggestions = array_column($result->fetch_all(MYSQLI_ASSOC),'email');
        }
        
    }


}


echo json_encode($suggestions);
?>