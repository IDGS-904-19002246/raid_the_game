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

$week_data = $model->selectBy(0);
$week = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $model->updateVefication($_POST['id'],$_POST['new']);
    $data = $model->select();

    $Subject = '';
    $body_greeting = '';
    $body_message = '';
    $body_bye = '';

    if ($_POST['new'] == '2') {
        $Subject = 'Información sobre tu participación en nuestra campaña';
        $body_greeting = 'Lamentablemente, tu ticket no ha sido aprobado para participar en nuestra campaña en esta ocasión. Queremos asegurarte que revisamos cuidadosamente cada ticket recibido, y aunque tu participación no ha sido aceptada en esta ocasión, apreciamos tu interés en nuestra marca y en nuestra campaña.';
        $body_message = ($_POST['msg'] =='' ? 'Te invitamos a seguir participando en futuras promociones y eventos.': 'Motivo: '.$_POST['msg']);
        $body_bye = '¡Gracias por formar parte de nuestra comunidad!';
    }
    if ($_POST['new'] == '1') {
        $Subject = 'Tu ticket ha sido aprobado';
        $body_greeting = 'Nos complace informarte que su ticket ha sido revisado y aprobado para participar, solo puede jugar una vez por cada ticket.';
        $body_message = '
            <p class="lead">Ya se puede participar, para ello solo precione "Jugar"</p>
            <a href="https://expertosraid.com/juego/index.php?ticket='.$_POST['ticket'].' target="_blank"><button class="btn btn-lg btn-warning my-4"><b>Jugar</b></button></a>
        ';
        $body_bye = 'Gracias por su atencion y por confiar en los expertos. Te deseamos mucha suerte!';
    }

    try {
        // GENERAR CUERPO DEL CORREO
        $template_content = file_get_contents('assets/email.php');
        $template_content = str_replace('<?php echo $user_name; ?>', $_POST['user_name'], $template_content);
    
        $template_content = str_replace('<?php echo $body_greeting; ?>', $body_greeting, $template_content);
        $template_content = str_replace('<?php echo $body_message; ?>', $body_message, $template_content);
        $template_content = str_replace('<?php echo $body_bye; ?>', $body_bye, $template_content);
        // Configurar el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.expertosraid.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'smtp@expertosraid.com';
        $mail->Password = 'Zc340b18c';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        // Configurar el correo
        $mail->setFrom('smtp@expertosraid.com', 'Remitente');
        $mail->addAddress($_POST['email'], 'Destinatario');
        $mail->Subject = $Subject ;
        $mail->Body = $template_content;
    
        // Enviar el correo
        $mail->send();
        echo 'El correo se ha enviado correctamente.';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['s'])) {
        if (is_numeric($_GET['s'])) {
            $week_data = $model->selectBy($_GET['s']);
            $week = $_GET['s'];
        }
    }
}


include 'view.php';
?>