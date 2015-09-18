<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Usuario</h2>
                <?php if(isset($this->error)) echo "<script>alert('". $this->error ."');</script>"; ?>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionUsuario">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <?php if(isset($this->rol)): ?>
                    <div class="service-box">
                        <i class="fa fa-2x fa-user-secret wow bounceIn text-primary" data-wow-delay=".2s">
                        <?php if($this->rol == 1): ?>
                            <a id="linkInfoPersonal" href="<?php echo BASE_URL ?>estudiante/infoEstudiante/<?php echo $this->id;?>">
                        <?php elseif($this->rol == 2): ?>
                            <a id="linkInfoPersonal" href="<?php echo BASE_URL ?>catedratico/infoCatedratico/<?php echo $this->id;?>">
                        <?php elseif($this->rol == 3 || $this->rol == 0): ?>
                            <a id="linkInfoPersonal" href="<?php echo BASE_URL ?>empleado/infoEmpleado/<?php echo $this->id;?>">
                        <?php endif;?>
                                Actualizar informacion personal
                            </a>
                        </i>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <form id="frmUsuario" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/actualizarUsuario/<?php echo $this->id ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-8 col-md-offset-2">
                            <table align="center">
                                <tr>
                                    <td colspan="2" style="width: 49%">
                                        <label class="text-primary" style="font-weight: normal;"><b>Nombre Usuario:</b>
                                        &nbsp;<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['nombre']; ?></label>
                                        <label class="text-primary" style="font-weight: normal;"><b>Unidad Academica:</b>
                                        &nbsp;<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['unidadacademica']; ?></label>
                                    </td>
                                    <td style="width: 2%">&nbsp;</td>
                                    <td colspan="2" rowspan="2" style="width: 49%">
                                        <div id="passInfo">
                                            <h4>Su contraseña debe cumplir con lo siguiente:</h4>
                                            <ul>
                                                <li id="letra" class="passInvalid">Tener al menos <strong>una letra</strong></li>
                                                <li id="mayus" class="passInvalid">Tener al menos <strong>una letra may&uacute;cula</strong></li>
                                                <li id="numero" class="passInvalid">Tener al menos <strong>un n&uacute;mero</strong></li>
                                                <li id="total" class="passInvalid">Ser de al menos <strong>8 car&aacute;cteress</strong></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                        <label class="text-primary" style="font-weight: normal;">Correo:</label>
                                        <input type="text" id="txtCorreo" name="txtCorreo" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['correo']; ?>">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5"><hr class="hr1"/></td>
                                </tr>
                                <tr class="text-primary">
                                    <th colspan="2" style="text-align:center">Cambio de pregunta secreta</th>
                                    <td>&nbsp;&nbsp;</td>
                                    <th colspan="2" style="text-align:center">Cambio de contraseña</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="text-primary" style="font-weight: normal;"><br/><b>Pregunta Actual:</b>
                                        &nbsp;<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['preguntasecreta']; ?></label>
                                        <input type="hidden" id="preguntaActual" name="preguntaActual" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['idpregunta']; ?>">
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td colspan="2">
                                        <input type="password" id="txtPassword" name="txtPassword" class="form-control input-lg" value="" placeholder="Escriba su Contraseña Actual">
                                        <input type="hidden" id="pass" name="pass" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['clave']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <?php if (isset($this->preguntas) && count($this->preguntas)): ?>
                                        <select id="slPregunta" name="slPregunta" class="form-control input-lg">
                                            <option value="">(Selecciona una pregunta)</option>
                                            <?php for ($i = 1; $i < count($this->preguntas); $i++) : ?>
                                            <option value="<?php echo $this->preguntas[$i]['codigo']; ?>">
                                                <?php echo $this->preguntas[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor; ?>
                                        </select>
                                        <?php else : ?>
                                            -- No hay informacion disponible --
                                    <?php endif; ?>
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td colspan="2">
                                        <input type="password" id="txtPasswordNuevo" name="txtPasswordNuevo" class="form-control input-lg" value="" placeholder="Contraseña Nueva" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="text" id="txtRespuesta" name="txtRespuesta" class="form-control input-lg" value="" disabled>
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td colspan="2">
                                        <input type="password" id="txtPasswordNuevo2" name="txtPasswordNuevo2" class="form-control input-lg" value="" placeholder="Repita la Contraseña Nueva" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3" align="center"><br/>
                                        <input type="submit" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name="hdPassValido" value="0">
                </form>

            </div>
        </div>
    </div>
</section>
