<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTitle</title>
    <!-- BOOTSTRAP 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <link rel="stylesheet" href="assets/SA/dist/sweetalert2.min.css">
    <script src="assets/SA/dist/sweetalert2.min.js"></script> -->
    <!-- MY ASSETS -->

    <style>
    #miTabla_info,
    #miTabla_paginate a,
    #miTabla_wrapper label,
    #miTabla_wrapper input {
        color: #F9E94D;
        font-weight: bolder;
        font-size: 1.5rem;
    }

    .my_td,
    .nav-link {
        color: #F9E94D !important;
    }

    select {
        background-color: yellow !important;
    }

    .my_bg {
        background-image: url("https://expertosraid.com/wp-content/uploads/2024/05/Fondo_raid_royale_1.png");
        background-position: 0px -1px;
        background-repeat: no-repeat;
        background-size: cover;
        /* https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg */
    }

    .my_bg2 {
        /* margin: 0;
        padding: 0; */
        height: 100vh;
        background-image: url('https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg');
        background-repeat: repeat-y;
        background-size: auto;
    }
    </style>
</head>

<body class="my_bg2">
    <div class="container">
        <div class="">

        </div>
    </div>
    <div class="p-2 my_bg">
        <div class="row p-4">
            <div class="col-sm-4">
                <img src="https://expertosraid.com/wp-content/uploads/2024/05/Recurso-1.png" alt=""
                    class="w-75 float-end">
            </div>
            <div class="col-sm-8">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#como-participar"><b><em>Cómo participar</em></b></a>
                        </li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#premios"><b><em>Premios</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#productos"><b><em>Productos</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#ranking"><b><em>Ranking</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#ganadores"><b><em>Ganadores</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="https://expertosraid.com/#contacto"><b><em>Contacto</em></b></a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row mb-4" style="height:800px;">

            <div class="col-sm-12">
                <table id="miTabla" class="table table-dark table-striped py-4">
                    <thead>
                        <tr class="text-center">
                            <th class="my_td"><b>#</b></th>
                            <th class="my_td"><b>Nombre</b></th>
                            <th class="my_td"><b>Telefono</b></th>
                            <th class="my_td"><b>Correo</b></th>
                            <th class="my_td"><b>Cuidad</b></th>

                            <th class="my_td"><b>Ticket</b></th>
                            <th class="my_td"><b>Puntaje</b></th>
                            <th class="my_td"><b>Fecha</b></th>
                            <th class="my_td"><b>Establecimiento</b></th>

                            <th class="my_td"><b>Jugado</b></th>
                            <th class="my_td"><b>Verificado</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d): ?>
                        <tr>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['id']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['user_name']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['telephone']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['email']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['state'].', '.$d['city']; ?></em></b></h6>
                            </td>

                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em>
                                            <?php echo $d['ticket']; ?>
                                            <button class="btn btn-sm bg-warning p-1"><i class="bi bi-eye data-to-alert"
                                                    data-bs-toggle="modal" data-bs-target="#my_alert"
                                                    data-to-alert='<?php echo json_encode($d); ?>'></i></button>

                                        </em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['score']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['date']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo $d['establishment']; ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em><?php echo ($d['status']==1?'Usado':'Disponible'); ?></em></b></h6>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h6><b><em>
                                            <?php
                                        switch($d['ticket_verificado']) {
                                            case 0:?>
                                            <span>Pendiente <button class="btn btn-sm bg-warning p-1 data-to-modal"
                                                    data-to-update='<?php echo json_encode($d['id']); ?>'
                                                    data-to-link='<?php echo json_encode($d['ticket']); ?>'
                                                    data-to-email='<?php echo json_encode($d['email']); ?>'><i
                                                        class="bi bi-pencil-square"></i></button></span>
                                            <?php
                                                    break;
                                            case 1:
                                                echo 'Validado';
                                                break;
                                            case 2:
                                                echo 'Rechazado';
                                                break;
                                        }
                                    ?>

                                        </em></b></h6>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</body>

<form action="index.php" method="POST" id="update">
    <input type="hidden" name="id" value="0">
    <input type="hidden" name="new" value="0">
    <input type="hidden" name="msg" value="">
    <input type="hidden" name="ticket" value="">
    <input type="hidden" name="email" value="">
</form>

<div class="modal fade" id="my_alert" tabindex="-1" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">

            <div class="modal-header"
                style="background-image: url('https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg');">
                <h4 class="text-light"><b>Ticket <span id="ticket"></span> - <span id="score"></span> Puntos</b>
                </h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i
                        class="bi bi-x-lg text-light"></i></div>
            </div>

            <div class="modal-body py-lg-10 px-lg-10">

                <h4><b>Nombre:</b> <span id="name"></span></h4>
                <div class="row">
                    <div class="col-sm-6">
                        <h6><b>Email:</b> <span id="email"></span></h6>
                    </div>
                    <div class="col-sm-6">
                        <h6><b>Telefono:</b> <span id="telephone"></span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h6><b>Estado:</b> <span id="state"></span></h6>
                    </div>
                    <div class="col-sm-6">
                        <h6><b>Cuidad:</b> <span id="city"></span></h6>
                    </div>
                </div>
                <h4><b>Establecimiento:</b> <span id="establishment"></span></h4>

                <div class="">
                    <img id="photo" src="" alt="NO_IMG" class="rounded-3" style="width: 100%;object-fit: cover;">
                </div>

            </div>

        </div>
    </div>
</div>

</html>
<script>
function F() {
    const swalWithTwoInputs = Swal.mixin({
        input: 'text',
        confirmButtonText: 'Siguiente &rarr;',
        showCancelButton: false,
        progressSteps: ['1', '2'],
        backdrop: `rgba(0,0,123,0.4) url("https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg") left top no-repeat`

    });
    const steps = ['Usuario', 'Contraseña'];

    swalWithTwoInputs.queue([{
            title: 'Ingresa tu usuario:',
            input: 'text',
            inputPlaceholder: 'Escribe aquí...',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debe ingresar su usuario!'
                }
            }
        },
        {
            title: 'Ingresa tu contraseña:',
            inputPlaceholder: 'Escribe aquí...',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debe ingresar tu contraseña!'
                }
            }
        }
    ]).then((r) => {
        if (r.value[0] == 'x' && r.value[1] == 'x') {
            Swal.fire({
                title: `Bienvenido ${r.value[0]}`,
                showDenyButton: false,
                showCancelButton: false
            });
        } else {
            Swal.fire({
                title: "Contraseña incorrecta",
                showDenyButton: false,
                showCancelButton: false,
                backdrop: `rgba(0,0,123,0.4) url("https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg") left top no-repeat`
            }).then(rr => {
                // location.reload();
                // window.location.href = "https://www.google.com";
                // window.history.back();
                F();
            });
        }
    });
}
$(document).ready(function() {
    // F();
    $('#miTabla').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });
});

const btnChange = document.querySelectorAll('.data-to-modal');
const btnPhoto = document.querySelectorAll('.data-to-alert');
btnChange.forEach(b => {
    b.addEventListener('click', () => {
        const object = b.getAttribute('data-to-update');
        const json = JSON.parse(object);
        const form = $('#update');
        form[0].reset();
        Swal.fire({
            title: "Cambiar la verificacion del ticket?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Validar",
            denyButtonText: "Rechazar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Validado", "", "success");
                form.find('input[name="id"]').val(json);
                form.find('input[name="new"]').val(1);
                form.submit();

            } else if (result.isDenied) {

                Swal.fire({
                    title: "Esta seguro de rechazar el ticket?",
                    text: 'Mencione la razon del rechazo del ticket',
                    icon: "info",
                    input: 'text',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const ticket = b.getAttribute('data-to-link');
                        const ticket_ = JSON.parse(ticket);

                        const email = b.getAttribute('data-to-email');
                        const email_ = JSON.parse(email);

                        form.find('input[name="msg"]').val(result.value);
                        form.find('input[name="ticket"]').val(ticket_);
                        form.find('input[name="email"]').val(email_);
                        form.find('input[name="id"]').val(json);
                        form.find('input[name="new"]').val(2);

                        form.submit();
                    }
                });

            }
        });
    });
});
btnPhoto.forEach(b => {
    b.addEventListener('click', () => {
        const object = b.getAttribute('data-to-alert');
        const json = JSON.parse(object);
        const my_alert = $('#my_alert');

        my_alert.find('#name').text(json.user_name);
        my_alert.find('#email').text(json.email);
        my_alert.find('#telephone').text(json.telephone);
        my_alert.find('#city').text(json.city);
        my_alert.find('#state').text(json.state);
        my_alert.find('#ticket').text(json.ticket);
        my_alert.find('#score').text(json.score);
        my_alert.find('#establishment').text(json.establishment);
        my_alert.find('#photo').prop("src",
            `http://localhost/puntajes2/assets/tickets_fotos/${json.photo}`);

    });
});
</script>