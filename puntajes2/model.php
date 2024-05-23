<?php
include '../database.php';
class Model
{

    public function select()
    {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }
        // $sql = "SELECT * FROM programas limit 10";
        $sql = "SELECT * FROM tbl_puntajes p
            ORDER BY id DESC";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
        $mysqli->close();
        return $datos;
    }

    public function selectTop()
    {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }
        // $sql = "SELECT * FROM programas limit 10";
        $sql = "SELECT * FROM tbl_puntajes p
            WHERE p.`status` = 1
            ORDER BY p.score DESC";

        $result = $mysqli->query($sql);

        $datos = array();
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        $mysqli->close();
        return $datos;
    }

    public function insert(
        $user_name,
        $ticket,
        $email,
        $telephone,
        $state,
        $city,
        $establishment,
        $photo,
        $date
    ) {
        $mysqli = conectarDB();

        $_user_name = $mysqli->real_escape_string($user_name);
        $_ticket = $mysqli->real_escape_string($ticket);
        $_email = $mysqli->real_escape_string($email);
        $_telephone = $mysqli->real_escape_string($telephone);

        $_state = $mysqli->real_escape_string($state);
        $_city = $mysqli->real_escape_string($city);
        $_establishment = $mysqli->real_escape_string($establishment);
        $_photo = $mysqli->real_escape_string($photo);

        $sql = "INSERT INTO tbl_puntajes (
            `user_name`,
            `ticket`,
            `email`,
            `telephone`,

            `state`,
            `city`,
            `establishment`,
            `photo`,

            `ticket_verificado`,`score`,`status`,`date`
            ) VALUES (
            '" . $_user_name . "',
            '" . $_ticket . "',
            '" . $_email . "',
            '" . $_telephone . "',

            '" . $_state . "',
            '" . $_city . "',
            '" . $_establishment . "',
            '" . $_photo . "',

            0,0,0,'" . $date . "'
            )";

        if ($mysqli->query($sql) == 1) {
            $mysqli->close();
            return true;
        } else {
            $mysqli->close();
            return false;
        }
    }
    public function selectBy($var) {
        $mysqli = conectarDB();
        if ($mysqli->connect_error) {die("Error de conexión: " . $mysqli->connect_error);}
        $sql = "SELECT COUNT(*) 'total' FROM  tbl_puntajes p WHERE p.ticket = '".$var."'";

        $result = $mysqli->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $valor = $row['total'];
            $mysqli->close();

            return $valor;
        } else {
            $mysqli->close();

            return 1;
        }
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