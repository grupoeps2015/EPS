<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="<?php echo BASE_URL; ?>login">
                    <i class="fa fa-4x fa-home wow bounceIn text-primary" data-wow-delay=".1s">
                        <p>Volver al Inicio</p>
                    </i>
                </a>
                <h2 class="section-heading">Reestablecer contraseña</h2>
                <hr class="primary">
                <div class="col-md-6 col-md-offset-3">
                    <p class="text-primary" style="text-align:center;">
                        Ingresa tu numero de <b>carnet/registro</b> personal para identificar tu cuenta
                    </p>
                    <hr class="hr1"/>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <form id="frmValidar" method="post" action="<?php echo BASE_URL?>gestionUsuario/claveOlvidada">
            
            <div id="divGenerales" class="col-md-6 col-md-offset-3" style="display: block;">
                <!-- Tabla con informacion general de usuario -->
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 49%">
                            <label class="text-primary" style="font-weight: normal;"><b>Carnet/Registro:</b></label>
                            <input type="number" id="txtId" name="txtId" min="10000000" max="299999999" class="form-control input-lg" value="">
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 49%" align="center"><br/>
                            <input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-warning btn-lg btn-block" style="width:75%">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <span id="spErrorId" class="text-danger"></span>
                            <span id="spAviso" class="text-warning"><?php if(isset($this->aviso)) echo $this->aviso;?></span>
                        </td>
                    </tr>
                </table>
                <table id="tbInfoUsr" style="width: 100%; display:none;">
                    <tr class="text-primary">
                        <th colspan="3"><br/>Ingrese una nueva contraseña y proporcione una respuesta a su pregunta secreta:</th>
                    </tr>
                    <tr>
                        <td style="width: 49%"><br/>
                            <input type="password" id="txtPasswordNuevo" name="txtPasswordNuevo" class="form-control input-lg" value="" placeholder="Contraseña Nueva"/>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 49%" class="text-primary"><br/>Pregunta secreta:<br/>
                            <span id="spPregunta" class="text-primary"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="txtPasswordNuevo2" name="txtPasswordNuevo2" class="form-control input-lg" value="" placeholder="Repita la Contraseña Nueva"/>
                        </td>
                        <td>&nbsp;</td>
                        <td><input type="text" id="txtRespuesta" name="txtRespuesta" class="form-control input-lg" value=""/></td>
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
                            <input type="button" id="btnCambiar" name="btnCambiar" value="Reestablecer" class="btn btn-warning btn-lg btn-block" style="width:75%">
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="passInfo" class="col-md-8 col-md-offset-2">
                <table style="width:100%" class="text-primary">
                    <tr>
                        <td style="width:50%">
                            <h4>Su contraseña debe cumplir con lo siguiente:</h4>
                            <ul>
                                <li id="letra" class="passInvalid">Tener al menos <strong>una letra</strong></li>
                                <li id="mayus" class="passInvalid">Tener al menos <strong>una letra may&uacute;cula</strong></li>
                            </ul>
                        </td>
                        <td style="width:50%">
                            <h4>&nbsp;</h4>
                            <ul>
                                <li id="numero" class="passInvalid">Tener al menos <strong>un n&uacute;mero</strong></li>
                                <li id="total" class="passInvalid">Ser de al menos <strong>8 car&aacute;cteress</strong></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <input type="hidden" name="hdEnvio" id="hdEnvio" value=""/>
        </form>
    </div>
    <div class="row"><br/><br/><br/><br/><br/></div>
</section>