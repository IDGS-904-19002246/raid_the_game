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
                                href="#como-participar"><b><em>Cómo participar</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="#premios"><b><em>Premios</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="#productos"><b><em>Productos</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="#ranking"><b><em>Ranking</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="#ganadores"><b><em>Ganadores</em></b></a></li>
                        <li class="nav-item px-1"><a class="nav-link text-uppercase text-warning"
                                href="#contacto"><b><em>Contacto</em></b></a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row" style="height:500px;">

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
                                            <a href="http://localhost/puntajes2/assets/tickets_fotos/<?php echo $d['photo']; ?>"
                                                target="_blank"><button class="btn btn-sm bg-warning p-1"><i
                                                        class="bi bi-eye"></i></button></a>
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
                                                    data-to-update='<?php echo json_encode($d['id']); ?>'><i
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
</form>

</html>
<script>

$(document).ready(function() {
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
    ]) then((r) => {
        if (result.value[0] == 'x' && result.value[1] == 'x') {
            console.log('ok');
        } else {
            Swal.fire({
                title: "Contraseña incorrecta",
                showDenyButton: false,
                showCancelButton: false
            })
        }
    });

    $('#miTabla').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });
});
const btnChange = document.querySelectorAll('.data-to-modal');
btnChange.forEach(b => {
    b.addEventListener('click', () => {
        const object = b.getAttribute('data-to-update');
        const json = JSON.parse(object);
        const form = $('#update');

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
                Swal.fire("Cancelado", "", "info");
                form.find('input[name="id"]').val(json);
                form.find('input[name="new"]').val(2);
                form.submit();
            }
        });
    });
});
</script>