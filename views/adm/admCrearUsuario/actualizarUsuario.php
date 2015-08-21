<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Usuario</h2>
                <!--<p><?php if (isset($this->datosUsr)) print_r($this->datosUsr); ?></p>  ahora le diremos que muestre datosUsr -->
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <br/><br/><br/>
                <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/actualizarUsuario">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center">
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
                                    <td colspan="3">Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['nombre']; ?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Correo:
                                        <input type="text" id="txtCorreo" name="txtCorreo" class="form-control input-lg" value="<?php if(isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['correo']; ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Unidad Academica:
                                        <input type="text" id="txtUnidadAcademica" name="txtUnidadAcademica" class="form-control input-lg" value="<?php if(isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['unidadacademica']; ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        Pregunta Secreta:
                                        <input type="text" id="txtPregunta" name="txtPregunta" class="form-control input-lg" value="<?php if(isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['preguntasecreta']; ?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Respuesta Secreta:
                                        <input type="text" id="txtRespuesta" name="txtRespuesta" class="form-control input-lg" value="<?php if(isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['respuestasecreta']; ?>">
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
