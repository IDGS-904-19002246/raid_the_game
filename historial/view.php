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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- MY ASSETS -->
    <style>
        #myTable2_info,
        #myTable2_paginate a,
        #myTable2_wrapper label,
        #myTable2_wrapper input {
            color: #F9E94D;
            font-weight: bolder;
            font-size: 1.5rem;
        }

        .my_td,
        h4,
        .form-control-solid, .form-control-solid::placeholder, #myTable2_previous, #myTable2_next, .dataTables_empty, select {
            background-color: transparent;
            color: #F9E94D !important;
        }

        .form-control-solid:focus {
            font-size: 1rem;
            color: #F9E94D;
        }
        td{
            background-color: transparent;
            color:#F9E94D;
        }
    </style>
</head>

<body style="background-color: transparent;">

    <div class="p-2">
        <div class="row">

            <div class="col-ms-12 p-2">
                <form action="index.php" method="POST">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-5">
                            <h4><b>Consulta tu puntaje <?php echo ($data['total'] == 0 ? '' : ': '.$data['total'].'Pts'); ?></b>
                            </h4>
                        </div>
                        <div class="col-sm-5 ">
                            <div class="fv-row">
                                <input type="text" class="form-control form-control-sm form-control-solid" name="var"
                                    required placeholder="Correo" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <input type="hidden" name="action" value="search">
                            <button type="submit" class="btn btn-warning"><b>Buscar</b></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5">
                <table id="myTable2" class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th class="my_td"><b>#</b></th>
                            <th class="my_td"><b>Nombre</b></th>
                            <th class="my_td"><b>Ticket</b></th>
                            <th class="my_td"><b>Puntaje</b></th>
                            <th class="my_td"><b>Fecha</b></th>
                        </tr>
                    </thead>

                    <?php if (count($data['data']) == 0): ?>
                        <!-- <h4 class="text-center"><b>Aun no hay datos</b></h4> -->
                    <?php else: ?>

                        <?php foreach ($data['data'] as $d): ?>
                            <tr>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $d['id'] ?></em></b></h4>
                                </td>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $d['user_name'] ?></em></b></h4>
                                </td>
                                <td style="background-color: transparent;color:#F9E94D;" class="my_td text-center border-0 py-2">
                                    <h4><b><em><?php echo $d['ticket'] ?></em></b></h4>
                                </td>
                                <td style="background-color: transparent;color:#F9E94D;" class="my_td text-center border-0 py-2">
                                    <h4><b><em><?php echo $d['score'] ?></em></b></h4>
                                </td>
                                <td style="background-color: transparent;color:#F9E94D;" class="my_td text-center border-0 py-2">
                                    <h4><b><em><?php echo $d['date'] ?></em></b></h4>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>


    </div>

</body>

</html>
<script>
    $(document).ready(function () {
        $('#myTable2').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "order": [[3, 'desc']] // Ordena por la segunda columna (índice 1) de forma descendente
        });
    });
</script>