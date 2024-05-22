<?php
include '../database.php';
class Model {

    public function select() {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        // $sql = "SELECT * FROM programas limit 10";
        $sql = "SELECT * FROM tbl_puntajes ORDER BY id DESC";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {$datos[] = $row;}
        $mysqli->close();
        return $datos;
    }

    public function selectTop() {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        // $sql = "SELECT * FROM programas limit 10";
        $sql = "SELECT * FROM tbl_puntajes p ORDER BY p.score DESC";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {$datos[] = $row;}

        $mysqli->close();
        return $datos;
    }

    // public function selectBy($var) {
    //     $mysqli = conectarDB();
    //     if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
    //     // $sql = "SELECT * FROM programas limit 10";
    //     $sql = "
    //         SET @var = '".$var."';

    //         SELECT * FROM tbl_puntajes p
    //         WHERE
    //             p.telephone = @var OR
    //             p.user_name = @var OR
    //             p.email = @var
    //         ORDER BY id DESC";

    //     $result = $mysqli->query($sql);

    //     $datos = array();
    //     while ($row = $result->fetch_assoc()) {$datos[] = $row;}

    //     $mysqli->close();
    //     return $datos;
    // }


//     -- FILTRADO
// SET @var = "juan 2";

// SELECT * FROM tbl_puntajes p
// WHERE
// 	p.telephone = @var OR
// 	p.user_name = @var OR
// 	p.email = @var
// ORDER BY id DESC LIMIT 2;

}
?>