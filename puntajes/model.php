<?php
include '../database.php';
class Model {

    public function select() {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }

        // $sql = "SELECT * FROM programas limit 10";
        $sql = "SELECT * FROM tbl_puntajes p ";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        $mysqli->close();
        return $datos;
    }

}
?>