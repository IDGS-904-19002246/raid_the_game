<?php
include 'database.php';
// http://localhost/HTML5/index.html?ticket=
// CREATE TABLE `tbl_puntajes` (
// 	`id` INT(10) NOT NULL AUTO_INCREMENT,
// 	`ticket` VARCHAR(50) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
// 	`score` INT(10) NOT NULL,
// 	`status` INT(10) NULL DEFAULT NULL,
// 	`date` DATE NULL DEFAULT NULL,
// 	PRIMARY KEY (`id`) USING BTREE
// )
// COLLATE='utf8mb4_0900_ai_ci'
// ENGINE=InnoDB
// AUTO_INCREMENT=8
// ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = conectarDB();
    $postData = file_get_contents("php://input");
    $jsonData = json_decode($postData, true);
    date_default_timezone_set('America/Mexico_City');

    $sql = "UPDATE tbl_puntajes SET
        status = 1,
        score = " . $jsonData['score'] . ",
        date = '" . date('Y-m-d') . "'
        WHERE ticket = '" . $jsonData['ticket'] . "' AND status = 0";

    $result = $mysqli->query($sql);
    if ($mysqli->query($sql) == 1) {
        echo 'TO BIEN';
    } else {
        echo 'TO MAL';
        echo $mysqli->error;
    }
    $mysqli->close();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['ticket'])) {
        $mysqli = conectarDB();
        // EXISTE EL TICKED

        $sql_no_repeat = "SELECT * FROM tbl_puntajes WHERE ticket = '" . $_GET['ticket'] . "'";
        $result_no_repeat = $mysqli->query($sql_no_repeat);
        if ($result_no_repeat->num_rows != 0) {
            // EL TIKED ESTA DISPONIBLE
            $sql_no_repeat2 = "SELECT * FROM tbl_puntajes WHERE ticket = '" . $_GET['ticket'] . "' AND status = 0";
            $result_no_repeat2 = $mysqli->query($sql_no_repeat2);
            if ($result_no_repeat2->num_rows != 0) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
        $mysqli->close();
    } else {
        echo '0';
    }
}

?>