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
</head>

<body style="background-color: transparent;">
    <script>
        <?php echo $alert;?>
    </script>

    <!-- MODAL ------------------------------------------------------------------------------- -->
    <div class="" id="my_modal" tabindex="-1" aria-modal="true">
        <div class="">
            <div class="modal-content">

                <div class="modal-header"
                    style="background-image: url('https://expertosraid.com/wp-content/uploads/2024/05/Fondo-1-scaled.jpg');">
                    <h4 class="text-light"><b>Registro de Nuevo Ticket</b></h4>
                    <!--<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><i class="bi bi-x-lg text-light"></i></div>-->
                        
                </div>
                <!-- ------------------------------------------------------------------------------- -->
                <div class="modal-body py-lg-10 px-lg-10">
                    <form action="https://expertosraid.com/juego/puntajes/index.php" method="POST" id="insert" enctype="multipart/form-data"  autocomplete="on">
                        <input type="hidden" name="action" value="insert">
                        <div class="fv-row mb-10">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Nombre</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="user_name" id="user_name"
                                maxlength="32" minlength="4" required placeholder="8-32 caracteres" />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Número de Ticket</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="ticket" id="ticket"
                                required placeholder="" maxlength="50" />
                        </div>
                        <div class="row">
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Correo</span>
                                </label>
                                <input type="email" class="form-control form-control-sm form-control-solid" name="email" id="email"
                                    required minlength="8" maxlength="50" placeholder="minimo 8 caracteres" />
                            </div>
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Telefono</span>
                                </label>
                                <input type="tel" class="form-control form-control-sm form-control-solid"
                                    name="telephone" required minlength="10" maxlength="10" placeholder="10 caracteres" id="telephone"/>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col sm-6">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Estado</span>
                                </label>
                                <select name="state" required class="form-control form-control-sm form-control-solid" id="state">
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
                                <input type="text" class="form-control form-control-sm form-control-solid" name="city" id="city"
                                    required minlength="4" maxlength="32" placeholder="minimo 4 caracteres" />
                            </div>
                        </div>
                        <div class="fv-row mb-4">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Establecimiento</span>
                            </label>
                            <input type="text" class="form-control form-control-sm form-control-solid"
                                name="establishment" required minlength="2" maxlength="50" id="establishment"
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
<button type="submit" class="btn btn-warning w-100 text-center my-4">Guardar</button>
                    </form>
                </div>
                <!-- ------------------------------------------------------------------------------- -->
                
            </div>
        </div>
    </div>

</body>

</html>
<script src="assets/formulario.js"></script>