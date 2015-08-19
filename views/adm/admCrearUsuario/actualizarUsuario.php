<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Usuario</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p> <!-- Aca le digo que muestre query -->
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                    <select id="slPerfil" name="slPerfil" class="form-control input-lg">
                        <option value="0">---- Seleccione un perfil ----</option>
                        <option value="1">Empleado</option>
                        <option value="2">Catedratico</option>
                        <option value="3">Estudiante</option>
                    </select>
                </div>
                <br/><br/><br/>
                <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr style="visibility: hidden">
                                    <td colspan="3">
                                        <?php if (isset($this->centros) && count($this->centros)): ?>
                                            <select id="slCentros" name="slCentros" class="form-control input-lg">
                                                <option value="default">---- Seleccione un centro ----</option>
                                                <?php for ($i = 0; $i < count($this->centros); $i++) : ?>
                                                    <option value="<?php echo $this->centros[$i]['codigo']; ?>">
                                                        <?php echo $this->centros[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                            &nbsp;
                                        <?php endif; ?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><----Seccion sin funcion</td>
                                </tr>
                                <tr>
                                    <td colspan="3">*Carnet
                                        <input type="text" id="txtCarnetEst" name="txtCarnetEst" class="form-control input-lg" value="<?php echo (int) $_POST['txtCarnetEst'] ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2">Foto: 
                                        <input type="text" id="txtFotoEst" name="txtFotoEst" class="form-control input-lg">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreEst1" name="txtNombreEst1" class="form-control input-lg" value="<?php echo htmlspecialchars($_POST['txtNombreEst1']); ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreEst2" name="txtNombreEst2" class="form-control input-lg" value="<?php echo htmlspecialchars($_POST['txtNombreEst2']); ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoEst1" name="txtApellidoEst1" class="form-control input-lg" value="<?php echo htmlspecialchars($_POST['txtApellidoEst1']); ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoEst2" name="txtApellidoEst2" class="form-control input-lg" value="<?php echo htmlspecialchars($_POST['txtApellidoEst2']); ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Correo:     
                                        <input type="text" id="txtCorreoEst" name="txtCorreoEst" class="form-control input-lg" value="<?php echo htmlspecialchars($_POST['txtCorreoEst']); ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>

            </div>
        </div>
    </div>
    <br />

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de edificios</h3>
                    <p class="text-muted">Capacidad de salones y gestion de uso</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-mortar-board wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de Unidades Acad&eacute;micas</h3>
                    <p class="text-muted">Faculades, Escuelas y Centros Regionales</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3>Gesti&oacute;n de personal</h3>
                    <p class="text-muted">Directores, Control Academico, Catedraticos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Gesti&oacute;n de estudiantes</h3>
                    <p class="text-muted">Alumnos regulares</p>
                </div>
            </div>
        </div>
    </div>
</section>
