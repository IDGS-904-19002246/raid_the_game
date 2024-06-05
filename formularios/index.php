<?php
include 'model.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'assets/PHPMailer-master/src/Exception.php';
include 'assets/PHPMailer-master/src/PHPMailer.php';
include 'assets/PHPMailer-master/src/SMTP.php';
$model = new Model();
$mail = new PHPMailer();
$alert = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["action"] == 'insert') {
        // echo $model->selectBy($_POST["ticket"]);
        if ($model->selectBy($_POST["ticket"]) == 0) {
            
            move_uploaded_file($_FILES['photo']['tmp_name'], 'assets/tickets_fotos/' . $_POST['ticket'].'.jpg');
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d');
            $response = $model->insert(
                $_POST["user_name"],
                $_POST["ticket"],
                $_POST["email"],
                $_POST["telephone"],
                $_POST["state"],
                $_POST["city"],
                $_POST["establishment"],
                ($_POST["ticket"].'.jpg'),
                $date
            );
            $Subject = 'Información sobre tu participación en nuestra campaña';
            $body_greeting = '<p>Nos complace informarte que su ticket ya se encuentra en revisión para su participación, le recordamos que solo puede jugar una vez por cada ticket.</p>';
            $body_bye = '<p>Gracias por su atencion y por confiar en los expertos. Te deseamos mucha suerte!</p>';
        
            try {
            // Configurar el servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.expertosraid.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'smtp@expertosraid.com';
                $mail->Password = 'Zc340b18c';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->CharSet = 'UTF-8';
            
                // Configurar el correo
                $mail->setFrom('smtp@expertosraid.com', 'expertosraid');
                $mail->addAddress($_POST["email"], $_POST["user_name"]);
                $mail->Subject = $Subject ;
                $mail->isHTML(true);
                $mail->Body = '<h4>Hola, '.$_POST['user_name'].'</h4>'.$body_greeting.$body_bye;
        
                // Enviar el correo
                $mail->send();
                $alert = "Swal.fire({icon: 'success',title: 'Datos guardados correctamente',showConfirmButton: false})";
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
                // return '0';
            }            
            // echo "<script>alert('El ticket fue registrado correctamente');</script>";
        }else {
            $alert = "Swal.fire({icon: 'error',title: 'Este ticket ya se encuentra registrado',showConfirmButton: false})";
            // echo "<script>alert('El ticket ya se encuentra en uso');</script>";
        }
    }
}

    

include 'view.php';
?>