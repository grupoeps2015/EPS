<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Usuario</h2>
                <hr class="primary">
                <?php if(isset($this->query)) echo $this->query;?>
                
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionUsuario">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
                <!-- Select Rol Usuario -->
                <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                    <select id="slPerfil" name="slPerfil" class="form-control input-lg">
                        <option value="0">---- Seleccione un perfil ----</option>
                        <option value="1">Empleado</option>
                        <option value="2">Catedratico</option>
                        <option value="3">Estudiante</option>
                    </select>
                    <br/><br/>
                </div>
                
                <!-- FORM Crear Estudiantes -->
                <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/agregarUsuario">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td colspan="3">*Carnet
                                        <input type="number" id="txtCarnetEst" name="txtCarnetEst" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" style="text-align:center">Foto<br/>
                                        <img src="<?php echo $_layoutParams['ruta_img']?>profile_picture.jpg" width="100px" height="50px" align="center" /><br/>
                                        <div id="divFotoEst" class="fileUpload btn btn-warning">
                                            <span id="spanEst">Cargar Imagen</span>
                                            <input type="file" class="upload" id="txtFotoEst" name="txtFotoEst"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreEst1" name="txtNombreEst1" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreEst2" name="txtNombreEst2" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoEst1" name="txtApellidoEst1" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoEst2" name="txtApellidoEst2" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarEst" name="btnAgregarEst" value="Nuevo Estudiante" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Correo:     
                                        <input type="email" id="txtCorreoEst" name="txtCorreoEst" class="form-control input-lg" value="">
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
                
                <!-- FORM Crear Catedratico -->
                <form id="frCatedraticos" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/agregarUsuario">
                    <div class="col-md-6 col-md-offset-3">
                        <div id="divCatedraticos" class="form-group">
                            <table>
                                <tr>
                                    <td colspan="3" style="text-align: right">Indique el rol del catedratico: </td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">
                                        <?php if(isset($this->docentes) && count($this->docentes)): ?>
                                        <select id="slDocente" name="slDocente" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->docentes); $i++) : ?>
                                            <option value="<?php echo $this->docentes[$i]['codigo'];?>">
                                                <?php echo $this->docentes[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Codigo Catedratico
                                        <input type="number" id="txtCodigoCat" name="txtCodigoCat" class="form-control input-lg" value="<?php if(isset($this->datos['txtCodigoCat'])) echo $this->datos['txtCodigoCat']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td><!--<input type="checkbox" id="cbGenerarCodigoCat" name="cbGenerarCodigoCat" value="Generar Nuevo">&nbsp;Generar codigo nuevo!-->&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" style="text-align:center">Foto<br/>
                                        <img src="<?php echo $_layoutParams['ruta_img']?>profile_picture.jpg" width="100px" height="50px" align="center" /><br/>
                                        <div id="divFotoCat" class="fileUpload btn btn-warning">
                                            <span id="spanCat">Cargar Imagen</span>
                                            <input type="file" class="upload" id="txtFotoCat" name="txtFotoCat"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreCat1" name="txtNombreCat1" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreCat1'])) echo $this->datos['txtNombreCat1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreCat2" name="txtNombreCat2" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreCat2'])) echo $this->datos['txtNombreCat2']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoCat1" name="txtApellidoCat1" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoCat1'])) echo $this->datos['txtApellidoCat1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoCat2" name="txtApellidoCat2" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoCat2'])) echo $this->datos['txtApellidoCat2']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarCat" name="btnAgregarCat" value="Nuevo Catedratico" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Correo:     
                                        <input type="email" id="txtCorreoCat" name="txtCorreoCat" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreoCat'])) echo $this->datos['txtCorreoCat']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="2">
                </form>
                
                <!-- FORM Crear Empleado -->
                <form id="frEmpleados" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/agregarUsuario">
                    <div class="col-md-6 col-md-offset-3">
                        <div id="divEmpleados" class="form-group">
                            <table>
                                <tr>
                                    <td colspan="2" rowspan="2" style="text-align:center">Foto<br/>
                                        <img id="pic1" name="pic1" src="<?php echo $_layoutParams['ruta_img']?>profile_picture.jpg" width="100px" height="50px" align="center" /><br/>
                                        <div id="divFotoEmp" name="divFotoEmp" class="fileUpload btn btn-warning">
                                            <span id="spanEmp">Cargar Imagen</span>
                                            <input type="file" class="upload" id="txtFotoEmp" name="txtFotoEmp"/>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <!--
                                    <td style="text-align:right;">
                                        Generar codigo nuevo&nbsp;
                                        <input type="checkbox" id="cbGenerarCodigoEmp" name="cbGenerarCodigoEmp" value="Generar Nuevo">
                                        <br />
                                    </td>
                                    -->
                                    <td><!--<input type="checkbox" id="cbGenerarCodigoCat" name="cbGenerarCodigoCat" value="Generar Nuevo">&nbsp;Generar codigo nuevo-->&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>*Codigo Empleado
                                        <input type="number" id="txtCodigoEmp" name="txtCodigoEmp" class="form-control input-lg" value="">
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreEmp1" name="txtNombreEmp1" class="form-control input-lg" value="">
                                        <br />
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreEmp2" name="txtNombreEmp2" class="form-control input-lg" value="">
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarEmp" name="btnAgregarEmp" value="Nuevo Empleado" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoEmp1" name="txtApellidoEmp1" class="form-control input-lg" value="">
                                        <br />
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoEmp2" name="txtApellidoEmp2" class="form-control input-lg" value="">
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        *Correo:     
                                        <input type="email" id="txtCorreoEmp" name="txtCorreoEmp" class="form-control input-lg" value="">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="3">
                </form>
                
            </div>
        </div>
    </div>
    <br />

    <div class="container">
        <div class="row">
            <form id="frFile" name="frFile" method='post' enctype="multipart/form-data" action='<?php echo BASE_URL; ?>gestionUsuario/cargarCSV'>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-file-text wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <br/>
                        <div id="divcsvFile" class="fileUpload btn btn-warning" >
                            <span>Cargar Archivo</span>
                            <input class="upload" type="file" id="csvFile" name="csvFile"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <p class="text-muted">Crea multiples usuarios utilizando archivos delimitados por comas</p>
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <div class="fileUpload btn btn-warning" >
                            <span>Procesar archivo .csv</span>
                            <input class="upload" type='submit' style="width: 100%" id="btnCargar" name='btnCargar'>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <input type="hidden" id="hdFile" name="hdFile" value="0">
            </form>
        </div>
    </div>
</section>
    
