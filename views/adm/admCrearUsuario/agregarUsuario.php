<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="<?php echo $_layoutParams['ruta_img']?>img10.png" width="100px" height="50px" align="left" />
        </div>

        <!-- Menu superior lateral derecho -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
				<li>
                    <a class="page-scroll" href="Menu.php">
                        <font color="black">Men&uacute;</font>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Usuario</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
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
                                <tr>
                                    <td colspan="3">*Carnet
                                        <input type="text" id="txtCarnetEst" name="txtCarnetEst" class="form-control input-lg" value="<?php if(isset($this->datos['txtCarnetEst'])) echo $this->datos['txtCarnetEst']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2">Foto: 
                                        <input type="text" id="txtFotoEst" name="txtFotoEst" class="form-control input-lg">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreEst1" name="txtNombreEst1" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreEst1'])) echo $this->datos['txtNombreEst1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreEst2" name="txtNombreEst2" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreEst2'])) echo $this->datos['txtNombreEst2']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoEst1" name="txtApellidoEst1" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoEst1'])) echo $this->datos['txtApellidoEst1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoEst2" name="txtApellidoEst2" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoEst2'])) echo $this->datos['txtApellidoEst2']?>">
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
                                        <input type="text" id="txtCorreoEst" name="txtCorreoEst" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreoEst'])) echo $this->datos['txtCorreoEst']?>">
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
                <form id="frCatedraticos" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario">
                    <div class="col-md-6 col-md-offset-3">
                        <div id="divCatedraticos" class="form-group">
                            <table>
                                <tr>
                                    <td>*Codigo Catedratico
                                        <input type="text" id="txtCodigoCat" name="txtCodigoCat" class="form-control input-lg" value="<?php if(isset($this->datos['txtCodigoCat'])) echo $this->datos['txtCodigoCat']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td><input type="checkbox" id="cbGenerarCodigoCat" name="cbGenerarCodigoCat" value="Generar Nuevo">&nbsp;Generar codigo nuevo</td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2">Foto: 
                                        <input type="text" id="txtFotoCat" name="txtFotoCat" class="form-control input-lg">
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
                                        <input type="text" id="txtCorreoCat" name="txtCorreoCat" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreoCat'])) echo $this->datos['txtCorreoCat']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="2">
                </form>
                <form id="frEmpleados" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario">
                    <div class="col-md-6 col-md-offset-3">
                        <div id="divEmpleados" class="form-group">
                            <table>
                                <tr>
                                    <td rowspan="2" colspan="2">Foto: 
                                        <input type="text" id="txtFotoEmp" name="txtFotoEmp" class="form-control input-lg">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td style="text-align:right;">Generar codigo nuevo&nbsp;<input type="checkbox" id="cbGenerarCodigoEmp" name="cbGenerarCodigoEmp" value="Generar Nuevo"></td>
                                    <td>&nbsp;</td>
                                    <td>*Codigo Empleado
                                        <input type="text" id="txtCodigoEmp" name="txtCodigoEmp" class="form-control input-lg" value="<?php if(isset($this->datos['txtCodigoEmp'])) echo $this->datos['txtCodigoEmp']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>*Primer Nombre:
                                        <input type="text" id="txtNombreEmp1" name="txtNombreEmp1" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreEmp1'])) echo $this->datos['txtNombreEmp1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Segundo Nombre:
                                        <input type="text" id="txtNombreEmp2" name="txtNombreEmp2" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreEmp2'])) echo $this->datos['txtNombreEmp2']?>">
                                        <br/>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarEmp" name="btnAgregarEmp" value="Nuevo Empleado" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        *Primer Apellido:
                                        <input type="text" id="txtApellidoEmp1" name="txtApellidoEmp1" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoEmp1'])) echo $this->datos['txtApellidoEmp1']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Segundo Apellido:
                                        <input type="text" id="txtApellidoEmp2" name="txtApellidoEmp2" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoEmp2'])) echo $this->datos['txtApellidoEmp2']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        *Correo:     
                                        <input type="text" id="txtCorreoEmp" name="txtCorreoEmp" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreoEmp'])) echo $this->datos['txtCorreoEmp']?>">
                                        <br/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="3">
                </form>
            </div>
        </div>
        <h4><?php if(isset($this->query)) echo $this->query?></h4>
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
    