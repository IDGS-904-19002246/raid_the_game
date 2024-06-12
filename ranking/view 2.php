<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" id="elementor-post-2-css" href="https://expertosraid.com/wp-content/uploads/elementor/css/post-2.css?ver=1716485117" media="all">
    <style>
    .my_td{
        background-color: transparent !important; 
        color: #F9E94D !important;
    }
    </style>
</head>

<body style="background-color: transparent;">

        <div class="row w-100 h-100">
            <div class="col-sm-12">
                <table id="MyTop" class="table table-striped">
                    <thead>
                        <!--<tr>-->
                        <!--    <th>Posición</th>-->
                        <!--    <th>Nombre</th>-->
                        <!--    <th>Puntaje</th>-->
                        <!--</tr>-->
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php foreach ($top as $d): ?>
                        <tr>
                            
                            <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-4 w-25">
                                <h1><b><em><?php echo $contador; ?></em></b></h1>
                            </td>
                            <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-4 w-50">
                                <h1><b><em><?php echo $d['user_name']; ?></em></b></h1>
                            </td>
                            <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-4">
                                <h1><b><em><?php echo $d['score']; ?> pts</em></b></h1>
                            </td>

                        </tr>
                        <?php $contador++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-12 d-flex justify-content-center">
                
                    <h4 class="text-center mx-4 my_td"><b><em>Ganadores de la semana, semana: 
                
                        <select class="form-select" id="weeks">
                            <option value="'2024-06-05' AND '2024-06-09'"><b>Junio 5 a Junio 9</b></option>
                            <option value="'2024-06-09' AND '2024-06-16'"><b>Junio 9 a Junio 16</b></option>
                            <option value="'2024-06-16' AND '2024-06-23'"><b>Junio 16 a Junio 23</b></option>
                            <option value="'2024-06-23' AND '2024-06-30'"><b>Junio 23 a Junio 30</b></option>
                            <option value="'2024-06-30' AND '2024-07-07'"><b>Junio 30 a Julio 07</b></option>
                            <option value="'2024-07-07' AND '2024-07-14'"><b>Julio 07 a Julio 14</b></option>
                            <option value="'2024-07-14' AND '2024-07-21'"><b>Julio 14 a Julio 21</b></option>
                            <option value="'2024-07-21' AND '2024-07-28'"><b>Julio 21 a Julio 28</b></option>
                        </select>
                </em></b></h4>
            </div>
                
            <div class="col-sm-12">
                <div class="row" style="min-height:500px;">
                    <div class="col-sm-12 mt-5 overflow-auto" >
                        <table id="myTable2" class="table table-dark table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th class="my_td"><b>#</b></th>
                                    <th class="my_td"><b>Nombre</b></th>
                                    <th class="my_td"><b>N.tickets</b></th>
                                    <th class="my_td"><b>Score</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($week_data) == 0): ?>
                                <h4 class="text-center py-4 my_td"><b>No hay registros</b></h4>
                                <?php else: ?>

                                <?php $contador = 1; ?>
                                <?php foreach ($week_data as $d): ?>
                                <tr style="background-color: transparent;">
                                
                                    <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-2">
                                        <h4><b><em><?php echo $contador; ?></em></b></h4>
                                    </td>
                                    <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-2">
                                        <h4><b><em><?php echo $d['names']; ?></em></b></h4>
                                    </td>
                                    <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-2">
                                        <h4><b><em><?php echo $d['nticket']; ?></em></b></h4>
                                    </td>
                                    <td style="background-color: transparent;color:#F9E94D;" class="text-center border-0 py-2">
                                        <h4><b><em><?php echo $d['max_score']; ?> Pts</em></b></h4>
                                    </td>

                                </tr>
                                <?php $contador++; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>


    
</body>

</html>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    $('#weeks').val(urlParams.get('s')??"'2024-06-05' AND '2024-06-09'");
    var select = document.getElementById('weeks');
    select.addEventListener('change', function() {
        var selectedOption = select.options[select.selectedIndex];
        var link = 'https://expertosraid.com/puntajes/index.php?s='+selectedOption.value;
        window.location.href = link;
    });
</script>