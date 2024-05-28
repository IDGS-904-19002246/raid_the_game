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
    .form-control-solid,
    .form-control-solid::placeholder,
    #myTable2_previous,
    #myTable2_next,
    .dataTables_empty,
    select {
        background-color: transparent;
        color: #F9E94D !important;
    }

    .form-control-solid:focus {
        font-size: 1rem;
        color: #F9E94D;
    }

    td {
        background-color: transparent;
        color: #F9E94D;
    }
    </style>
</head>

<body style="background-color: transparent;">
    <div class="p-2">
        <div class="row">

            <div class="col-sm-12 mt-5">
                <table id="myTable2" class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th class="my_td"><b>#</b></th>
                            <th class="my_td"><b>Nombre</b></th>
                            <th class="my_td"><b>N.tickets</b></th>
                            <th class="my_td"><b>Score</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php foreach ($data as $d): ?>
                            <tr>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $contador; ?></em></b></h4>
                                </td>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $d['names']; ?></em></b></h4>
                                </td>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $d['nticket']; ?></em></b></h4>
                                </td>
                                <td class="my_td text-center border-0 py-2" style="background-color: transparent;color:#F9E94D;">
                                    <h4><b><em><?php echo $d['max_score']; ?></em></b></h4>
                                </td>
                            </tr>
                        <?php $contador++; ?>                            
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</body>



</html>