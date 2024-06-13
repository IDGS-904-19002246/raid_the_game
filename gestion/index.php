<?php
include 'model.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'assets/PHPMailer-master/src/Exception.php';
include 'assets/PHPMailer-master/src/PHPMailer.php';
include 'assets/PHPMailer-master/src/SMTP.php';

$model = new Model();
$data = $model->select();
$mail = new PHPMailer();

$week_data = $model->selectBy("'2024-06-17' AND '2024-06-23'");
$week = 0;
$weeks_optcions = array(
    // ANTES
    // "'2024-06-05' AND '2024-06-09'","'2024-06-09' AND '2024-06-16'","'2024-06-16' AND '2024-06-23'","'2024-06-23' AND '2024-06-30'",
    // "'2024-06-30' AND '2024-07-07'","'2024-07-07' AND '2024-07-14'","'2024-07-14' AND '2024-07-21'","'2024-07-21' AND '2024-07-28'"
    // NUEVOS
    "'2024-06-17' AND '2024-06-23'","'2024-06-24' AND '2024-06-30'","'2024-07-01' AND '2024-07-07'","'2024-07-08' AND '2024-07-14'",
    "'2024-07-15' AND '2024-07-21'","'2024-07-22' AND '2024-07-28'","'2024-07-29' AND '2024-08-04'","'2024-08-05' AND '2024-08-11'"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $model->updateVefication($_POST['id'],$_POST['new']);
    $data = $model->select();

    $Subject = '';
    $body_greeting = '';
    $body_message = '';
    $body_bye = '';

    if ($_POST['new'] == '2') {
        $Subject = 'Información sobre tu participación en nuestra campaña';
        $body_greeting = '<p>Lamentablemente, tu ticket no ha sido aprobado para participar en nuestra campaña en esta ocasión. Queremos asegurarte que revisamos cuidadosamente cada ticket recibido, y aunque tu participación no ha sido aceptada en esta ocasión, apreciamos tu interés en nuestra marca y en nuestra campaña.</p>';
        $body_message = ($_POST['msg'] =='' ? '<p>Te invitamos a seguir participando en futuras promociones y eventos.</p>': '<p>Motivo: '.$_POST['msg'].'</p>');
        $body_bye = '<p>¡Gracias por formar parte de nuestra comunidad!</p>';
    }
    if ($_POST['new'] == '1') {
        $Subject = '¡FELICIDADES!';
        $body_greeting = '<p>Nos complace informarte que su ticket ha sido revisado y aprobado para participar, solo puede jugar una vez por cada ticket.</p>';
        $body_message = '
            <p>
                Tu ticket ha sido revisado y aprobado para participar.<br>
                *Solo se puede participar una vez por ticket*
            </p>
 
            <a href="https://expertosraid.com/juego/index.php?ticket='.$_POST['ticket'].'"><b>JUEGUE AQUÍ</b></a>
            <p>Gracias por confiar en los expertos.<br>¡Mucha suerte!</p>
        ';
        $body_bye = '<p>Gracias por su atencion y por confiar en los expertos. Te deseamos mucha suerte!</p>';
    }

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
        $mail->addAddress($_POST['email'], $_POST['name']);
        $mail->Subject = $Subject ;
        $mail->isHTML(true);
        $mail->Body = '<h4>Hola, '.$_POST['name'].'</h4>'.$body_greeting.$body_message.$body_bye;

        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['s'])) {
        if (in_array($_GET['s'], $weeks_optcions)) {
            $week_data = $model->selectBy($_GET['s']);
            $week = $_GET['s'];
        }
    }
}

include 'view.php';
?>