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
        #miTabla_info, #miTabla_paginate a,
        #miTabla_wrapper label, #miTabla_wrapper input{
            color:#F9E94D;
            font-weight: bolder;
            font-size: 1.5rem;
        }
        .my_td{
            background-color: transparent;
            color:#F9E94D;
        }
    </style>
</head>

<body style="background-color: transparent;">

    <div class="p-2">
        <div class="row">
            <!-- <div class="col-sm-3 bg-danger">
                <table id="MyTop" class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Nombre</th>
                            <th>Puntaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php foreach ($top as $d): ?>
                        <tr>
                            <td><?php echo $contador; ?></td>
                            <td><?php echo $d['user_name']; ?></td>
                            <td><?php echo $d['score']; ?> pts</td>

                            <td><button class="btn btn-sm btn-warning btn-to-alert"
                                    data-to-modal='<?php echo json_encode($d); ?>' data-bs-toggle="modal"
                                    data-bs-target="#my_alert">+</button></td>
                        </tr>
                        <?php $contador++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-1">
                <button id="to_insert" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#my_modal">Dar de
                    alta</button>
            </div> -->

            <div class="col-sm-12">
                <table id="miTabla" class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th class="my_td"><b>#</b></th>
                            <th class="my_td"><b>Nombre</b></th>
                            <th class="my_td"><b>Ticket</b></th>
                            <th class="my_td"><b>Puntaje</b></th>
                            <th class="my_td"><b>Fecha</b></th>
                            <!-- <th class="my_td"><b>Telefono</b></th> -->
                            <!-- <th class="my_td"><b>Correo</b></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d): ?>
                        <tr>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['id'] ?></em></b></h4>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['user_name'] ?></em></b></h4>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['ticket'] ?></em></b></h4>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['score'] ?></em></b></h4>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['date'] ?></em></b></h4>
                            </td>
                            <!-- <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['telephone'] ?></em></b></h4>
                            </td>
                            <td class="my_td text-center border-0 py-2">
                                <h4><b><em><?php echo $d['email'] ?></em></b></h4>
                            </td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    <!-- ALERT ------------------------------------------------------------------------------- -->
    <!-- <div class="modal fade" id="my_alert" tabindex="-1" aria-modal="true">
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
    </div> -->
    <!-- MODAL ------------------------------------------------------------------------------- -->
    <!-- <div id="my_modal" tabindex="-1" aria-modal="true" class="row w-100 h-100">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">

                <div class="modal-header"
                    style="background-image: url('https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg');">
                    <h4 class="text-light"><b>Registro de Nuevo Ticket</b></h4> -->
                    <!-- <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i class="bi bi-x-lg text-light"></i></div> -->
                        
                <!-- </div> -->
                <!-- ------------------------------------------------------------------------------- -->
                <!-- <div class="modal-body py-lg-10 px-lg-10">
                    <form action="index.php" method="POST" id="insert" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="insert">
                        <div class="fv-row mb-10">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Nombre</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="user_name"
                                maxlength="32" minlength="8" required placeholder="8-32 caracteres" />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Ticket</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="ticket"
                                required placeholder="" />
                        </div>
                        <div class="row">
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Correo</span>
                                </label>
                                <input type="email" class="form-control form-control-sm form-control-solid" name="email"
                                    required minlength="8" maxlength="32" placeholder="minimo 8 caracteres" />
                            </div>
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Telefono</span>
                                </label>
                                <input type="tel" class="form-control form-control-sm form-control-solid"
                                    name="telephone" required minlength="10" maxlength="10" placeholder="10 caracteres" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Estado</span>
                                </label>
                                <select name="state" required class="form-control form-control-sm form-control-solid">
                                    <option value="Aguascalientes">Aguascalientes</option>
                                    <option value="Baja California">Baja California</option>
                                    <option value="Baja California Sur">Baja California Sur</option>
                                    <option value="Campeche">Campeche</option>
                                    <option value="Chiapas">Chiapas</option>
                                    <option value="Chihuahua">Chihuahua</option>
                                    <option value="CDMX">CDMX</option>
                                    <option value="Coahuila">Coahuila</option>
                                    <option value="Colima">Colima</option>
                                    <option value="Durango">Durango</option>
                                    <option value="Guanajuato">Guanajuato</option>
                                    <option value="Guerrero">Guerrero</option>
                                    <option value="Hidalgo">Hidalgo</option>
                                    <option value="Jalisco">Jalisco</option>
                                    <option value="Estado de México">Estado de México</option>
                                    <option value="Michoacán">Michoacán</option>
                                    <option value="Morelos">Morelos</option>
                                    <option value="Nayarit">Nayarit</option>
                                    <option value="Nuevo León">Nuevo León</option>
                                    <option value="Oaxaca">Oaxaca</option>
                                    <option value="Puebla">Puebla</option>
                                    <option value="Querétaro">Querétaro</option>
                                    <option value="Quintana Roo">Quintana Roo</option>
                                    <option value="San Luis Potosí">San Luis Potosí</option>
                                    <option value="Sinaloa">Sinaloa</option>
                                    <option value="Sonora">Sonora</option>
                                    <option value="Tabasco">Tabasco</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Tlaxcala">Tlaxcala</option>
                                    <option value="Veracruz">Veracruz</option>
                                    <option value="Yucatán">Yucatán</option>
                                    <option value="Zacatecas">Zacatecas</option>
                                </select>
                            </div>

                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Cuidad</span>
                                </label>
                                <input type="text" class="form-control form-control-sm form-control-solid" name="city"
                                    required minlength="4" maxlength="32" placeholder="minimo 4 caracteres" />
                            </div>
                        </div>
                        <div class="fv-row mb-4">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Establecimiento</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid"
                                name="establishment" required minlength="6" maxlength="32"
                                placeholder="minimo 6 caracteres" />
                        </div>

                        <div class="fv-row mb-10 form-group  mb-4">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2" for="fileInput">
                                <span class="required">Foto del ticket</span>
                            </label>
                            <input type="file" class="form-control-file" name="photo" id="fileInput" accept="image/*"
                                required>
                            <button type="button" class="btn btn-sm btn-danger d-none" id="fileClear"><i
                                    class="bi bi-x-lg text-light"></i></button>
                        </div>
                        <div class="mt-3">
                            <img id="imagePreview" src="#" alt="NO IMG" class="img-fluid d-none" style="width: 100%;object-fit: cover;">
                        </div>

                    </form>
                </div> -->
                <!-- ------------------------------------------------------------------------------- -->
                <!-- <div class="modal-footer"
                    style="background-image: url('https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg');">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning" form="insert">Guardar</button>
                </div>
            </div>
        </div>
    </div> -->

</body>

</html>
<script src="assets/formulario.js"></script>