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
    <!-- MY ASSETS -->
    <link rel="stylesheet" href="assets/estyles.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-3 bg-danger">
                <table id="MyTop" class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Puntaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php foreach ($data as $d): ?>
                        <tr>
                            <td><?php echo $contador;?></td>
                            <td><?php echo $d['user_name'];?></td>
                            <td><?php echo $d['score'];?></td>

                            <td><button class="btn btn-sm btn-warning btn-to-alert"
                                    data-to-modal='<?php echo json_encode($d); ?>' data-bs-toggle="modal"
                                    data-bs-target="#my_alert">Ver mas</button></td>
                        </tr>
                        <?php $contador++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-1">
                <button id="to_insert" class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#my_modal">Dar de alta</button>
            </div>

            <div class="col-sm-8 bg-warning">
                <table id="miTabla" class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Ticket</th>
                            <th>Puntaje</th>

                            <th>Fecha</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d): ?>
                        <tr>
                            <td><?php echo $d['id']?></td>
                            <td><?php echo $d['user_name']?></td>
                            <td><?php echo $d['ticket']?></td>
                            <td><?php echo $d['score']?></td>

                            <td><?php echo $d['date']?></td>
                            <td><?php echo $d['telephone']?></td>
                            <td><?php echo $d['email']?></td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>


    </div>
<!-- ALERT ------------------------------------------------------------------------------- -->
    <div class="modal fade" id="my_alert" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4><b>Ticket <span id="ticket"></span> - <span id="score"></span> Puntos</b></h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i
                            class="bi bi-x-lg"></i></div>
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
                        <img id="photo" src="" alt="NO_IMG"
                        class="rounded-3"
                        style="width: 100%;height: 100%;object-fit: cover;">
                    </div>

                </div>

            </div>
        </div>
    </div>
<!-- MODAL ------------------------------------------------------------------------------- -->
    <div class="modal fade" id="my_modal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4><b>Ticket <span id="ticket"></span> - <span id="score"></span> Puntos</b></h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i
                            class="bi bi-x-lg"></i></div>
                </div>

                <div class="modal-body py-lg-10 px-lg-10">
                    <form action="" method="POST" id="insert">

                    <div class="fv-row mb-10">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Nombre</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="name" required />
                        </div>

                    </form>

                </div>

                <div class="modal-futter"></div>

            </div>
        </div>
    </div>

</body>

</html>
<script>
$(document).ready(function() {
    $('#miTabla').DataTable();
});
const btnAlert = document.querySelectorAll('.btn-to-alert');
const btnModalInsert = $('#to_insert')[0];
btnModalInsert.addEventListener('click',()=>{
    $('#insert')[0].reset()
});
btnAlert.forEach(btn => {
    btn.addEventListener('click', () => {
        const object = btn.getAttribute('data-to-modal');
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
        my_alert.find('#photo').prop("src",`http://localhost/puntajes/assets/tickets_fotos/${json.photo}`);
    });
});
</script>

