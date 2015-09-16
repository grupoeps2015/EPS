<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Te damos la bienvenida <?php echo " " . $_SESSION["nombre"]; ?></h2>
                <hr class="primary">
                <div class="col-md-8 col-md-offset-2">
                    <p class="text-primary" style="text-align:left;">
                        Antes de utilizar el sistema es necesario que actualices tus datos personales y los datos generales de usuario.
                        Por favor, completa los siguientes formularios para dar por activado tu usuario en el sistema. ¡Gracias!
                    </p>
                    <hr class="hr1"/>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <form id="frmValidar" method="post" action="<?php echo BASE_URL?>gestionUsuario/activarUsuario">
            
            <div id="divGenerales" class="col-md-8 col-md-offset-2" style="display: block;">
                <!-- Tabla con informacion general de usuario -->
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 49%">
                            <label class="text-primary" style="font-weight: normal;"><b>Nombre Usuario:</b>
                            &nbsp;<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['nombre']; ?></label><br/>
                            <label class="text-primary" style="font-weight: normal;"><b>Unidad Academica:</b>
                            &nbsp;<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['unidadacademica']; ?>&nbsp;</label>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td>
                            <label class="text-primary" style="font-weight: normal;"><b>Correo registrado:</b></label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control input-lg" value="<?php if (isset($this->datosUsr) && count($this->datosUsr)) echo $this->datosUsr[0]['correo']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <span id="spErrorCorreo" class="text-danger"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><hr class="hr1"/></td>
                    </tr>
                    <tr class="text-primary">
                        <th style="text-align:center">Establecer contraseña*</th>
                        <td>&nbsp;</td>
                        <th style="text-align:center">Establecer pregunta secreta*</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="txtPasswordNuevo" name="txtPasswordNuevo" class="form-control input-lg" value="" placeholder="Contraseña Nueva"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <select id="slPregunta" name="slPregunta" class="form-control input-lg">
                            <?php if (isset($this->preguntas) && count($this->preguntas)): ?>
                                <option value="">(Selecciona una pregunta)</option>
                                <?php for ($i = 1; $i < count($this->preguntas); $i++) : ?>
                                <option value="<?php echo $this->preguntas[$i]['codigo']; ?>">
                                    <?php echo $this->preguntas[$i]['nombre']; ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            <?php else : ?>
                                <option value="">(No hay informacion disponible)</option>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="txtPasswordNuevo2" name="txtPasswordNuevo2" class="form-control input-lg" value="" placeholder="Repita la Contraseña Nueva"/>
                        </td>
                        <td>&nbsp;</td>
                        <td colspan="2">
                            <input type="text" id="txtRespuesta" name="txtRespuesta" class="form-control input-lg" value="" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span id="spErrorClave" class="text-danger"></span>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <span id="spErrorPregunta" class="text-danger"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><br/>
                            <input type="button" id="btnContinuar1" name="btnContinuar1" value="Continuar" class="btn btn-warning btn-lg btn-block" style="width:50%">
                        </td>
                    </tr>
                </table>
            </div>
        
            <div id="divEspecificos" class="col-md-4 col-md-offset-2" style="display: none;">
                <!-- Tabla con informacion personal -->
                <table class="text-primary" style="width: 100%;">
                    <tr>
                        <td colspan="3" class="text-primary" align="center">
                            <b>Informaci&oacute;n General</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br/>Nacionalidad:
                            <select id="slPaises" name="slPaises" class="form-control input-lg">
                            <?php if(isset($this->paises) && count($this->paises)): ?>
                                <option value="">(Seccione su pa&iacute;s de origen)*</option>
                                <?php for($i =0; $i < count($this->paises); $i++) : ?>
                                <option value="<?php echo $this->paises[$i]['codigo'];?>">
                                    <?php echo $this->paises[$i]['nombre']; ?>
                                </option>
                                <?php endfor;?>
                            <?php else : ?>
                                <option value="">- No hay informaci&oacute;n disponible -</option>
                            <?php endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br/>Direcci&oacute;n:
                            <select id="slDeptos" name="slDeptos" class="form-control input-lg">
                                <?php if(isset($this->deptos) && count($this->deptos)): ?>
                                    <option value="">(Seleccione un Departamento)*</option>
                                    <?php for($i =0; $i < count($this->deptos); $i++) : ?>
                                    <option value="<?php echo $this->deptos[$i]['codigo'];?>">
                                        <?php echo $this->deptos[$i]['nombre']; ?>
                                    </option>
                                    <?php endfor;?>
                                <?php else : ?>
                                    <option value="">- No hay informaci&oacute;n disponible -</option>
                                <?php endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <select id="slMunis" name="slMunis" class="form-control input-lg">
                                <option value="" disabled>(Seleccione un Municipios)*</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 68%">
                            <input id="txtDireccion" name="txtDireccion" type="text" class="form-control input-lg" value="" placeholder="Ejemplo: 5ta calle 1-20" style="width:98%"/>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 30%">
                            <input id="txtZona" name="txtZona" type="number" min="0" max="27" class="form-control input-lg" value="" placeholder="Zona"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-primary"><br />Tel&eacute;fono:
                            <input id="txtTelefono" name="txtTelefono" type="number" min="22000000" max="99999999" class="form-control input-lg" value="" placeholder="22000000">
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            
            <div id="divEmergencia" class="col-md-4" style="display: none;"> 
                <!-- Tabla con informacion de estudiante en caso de emergencia -->
                <table class="text-primary" style="width: 100%;">
                    <tr>
                        <td colspan="3" class="text-primary" align="center">
                            <b>En caso de emergencia</b>
                        </td>
                    </tr>
                    <tr>
                        <td id="emg2" style="text-align:center">
                            ¿Posee seguro m&eacute;dico?<br/>
                            <input type="radio" id="rbSeguro" name="rbSeguro" value="1" checked>Si&nbsp;&nbsp;
                            <input type="radio" id="rbSeguro" name="rbSeguro" value="0">No
                        </td>
                        <td>&nbsp;</td>
                        <td id="emg3"><br/>Tel&eacute;fono de emergencia
                            <input id="txtTelefonoE" name="txtTelefonoE" type="number" min="22000000" max="99999999" class="form-control input-lg" value="" placeholder="22000000">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 39%">Tipo de Sangre</td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 59%">
                            <input id="txtTipoSangre" name="txtTipoSangre" type="text" class="form-control input-lg" value="" placeholder="Ejemplo: O+"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Centro Asistencial:&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <input id="txtHospital" name="txtHospital" type="text" class="form-control input-lg" value="" placeholder="Trasladarlo al..."/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br/>Alergias:
                            <textarea id="txtAlergias" name="txtAlergias" rows="4" class="form-control input-lg" style="resize: none;"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="divBotones" class="col-md-8 col-md-offset-2" style="display: none;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                    <tr>
                        <td align="left" style="width: 43%"><br/>
                            <input type="button" id="btnRegresar1" name="btnRegresar1" value="Regresar" class="btn btn-warning btn-lg btn-block" style="width:60%">
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right" style="width: 43%"><br/>
                            <input type="submit" id="btnContinuar2" name="btnContinuar2" value="Continuar" class="btn btn-warning btn-lg btn-block" style="width:60%">
                        </td>
                    </tr>
                </table>
            </div>
            <input type="hidden" id="hdWho" name="hdWho" value="<?php echo $_SESSION['usuario']?>">
            <input type="hidden" id="hdRol" name="hdRol" value="<?php echo $_SESSION['rol']?>">
        </form>
    </div>
    
</section>
