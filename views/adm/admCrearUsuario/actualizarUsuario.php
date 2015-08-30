<?php session_start() ?>
<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Usuario</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p> 
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>admCrearUsuario">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-user-secret wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>admEstudiante">
                                Actualizar informacion personal
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <br/><br/><br/>
                <form id="frmUsuario" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/actualizarUsuario/3">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center" >
                                <tr>
                                    <td><label style="font-weight: normal;">Nombre Usuario:</label>
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['nombre']; ?>">
                                        <br/>
                                    </td>
                                    <td> <label style="font-weight: normal; margin-left: 20px;">Unidad Academica:</label>
                                        <label style="margin-left: 20px;"><?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['unidadacademica']; ?></label>
                                        
                                    </td>
                                    <td  style="display:none" >
                                        <?php if (isset($this->unidades) && count($this->unidades)): ?>
                                            <select id="slUnidadAcademica" name="slUnidadAcademica" class="form-control input-lg">
                                                <option value="">(Unidad Academica)
                                                </option>
                                                <?php for ($i = 0; $i < count($this->unidades); $i++) : ?>
                                                    <option value="<?php echo $this->unidades[$i]['codigo']; ?>">
                                                        <?php echo $this->unidades[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                            <input type="text" id="txtUnidadAcademica" name="txtUnidadAcademica" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['unidadacademica']; ?>">
                                            <br/>
                                        <?php endif; ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td><label style="font-weight: normal;">Correo:</label>
                                        <input type="text" id="txtCorreo" name="txtCorreo" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['correo']; ?>">
                                        <br/>
                                    </td>

                                    <td  style="display:none" ><label style="font-weight: normal;">Carrera:</label>
                                        <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                                            <option value="" disabled>(Carreras)</option>
                                        </select>
                                    </td>

                                    <td > <label style="font-weight: normal; margin-left: 20px;">Contraseña Actual:</label>
                                        <input type="password" id="txtPassword" style="margin-left: 20px;" name="txtPassword" class="form-control input-lg" value="">
                                        <input type="hidden" id="pass" name="pass" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['clave']; ?>">
                                        <br/>
                                    </td>


                                </tr>
                                <tr>
                                    <td><label style="font-weight: normal;">Nueva Contraseña:</label>
                                        <input type="text" id="txtPasswordNuevo" name="txtPasswordNuevo" class="form-control input-lg" value="">

                                    </td>
                                    <td><label style="font-weight: normal; margin-left: 20px;">Repita la nueva Contraseña:</label>
                                        <input type="text" id="txtPasswordNuevo2" style="margin-left: 20px;" name="txtPasswordNuevo2" class="form-control input-lg" value="">

                                    </td>

                                </tr>

                                <tr>

                                    <td><label style="font-weight: normal;">Pregunta Secreta:</label>

                                        <?php if (isset($this->preguntas) && count($this->preguntas)): ?>
                                            <select id="slPregunta" name="slPregunta" class="form-control input-lg">
                                                <option value="">(Selecciona tu pregunta secreta)
                                                </option>
                                                <?php for ($i = 1; $i < count($this->preguntas); $i++) : ?>
                                                    <option value="<?php echo $this->preguntas[$i]['codigo']; ?>">
                                                        <?php echo $this->preguntas[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                        <td>&nbsp;</td>
                                    <?php endif; ?>
                                    </td>

                                    <td>
                                        <br/>
                                        <label style="font-weight: normal; margin-left: 20px;">Respuesta Secreta:</label>
                                        <input type="text" style="margin-left: 20px;" id="txtRespuesta" name="txtRespuesta" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['respuestasecreta']; ?>">
                                        <br/>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="submit" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
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
