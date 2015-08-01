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
                                        <input type="text" id="txtCorreo" name="txtCorreoEst" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreoEst'])) echo $this->datos['txtCorreoEst']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                
                <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                    <div id="divCatedraticos" class="form-group">
                        *Nombre:
                        <input type="text" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>"><br/>
                        *Correo:     
                        <input type="text" name="txtCorreo" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreo'])) echo $this->datos['txtCorreo']?>"><br/>
                        Foto: <input type="text" name="txtFoto" class="form-control input-lg"><br/>
                        <br />
                        <input type="submit" name="btnAgregar" value="Crear Nuevo" class="btn btn-danger btn-lg btn-block">
                    </div>
                </div>
                
                <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                    <div id="divEmpleados" class="form-group">
                        *Nombre:
                        <input type="text" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>"><br/>
                        *Correo:     
                        <input type="text" name="txtCorreo" class="form-control input-lg" value="<?php if(isset($this->datos['txtCorreo'])) echo $this->datos['txtCorreo']?>"><br/>
                        Foto: <input type="text" name="txtFoto" class="form-control input-lg"><br/>
                        <br />
                        <input type="submit" name="btnAgregar" value="Crear Nuevo" class="btn btn-danger btn-lg btn-block">
                    </div>
                </div>
                
                    <!-- Informacion por defecto al momento de crear un usuario nuevo -->
                    <input type="hidden" id="txtPass" name="txtPass" value="default"><br/>
                    <input type="hidden" id="txtPregunta" name="txtPregunta" value="0">
                    <input type="hidden" id="txtRespuesta" name="txtRespuesta" value="USAC">
                    <input type="hidden" id="txtIntentos" name="txtIntentos" value="5">
                    <input type="hidden" id="txtUnidadAcademica" name="txtUnidadAcademica" value="<?php echo UNIDAD_ACADEMICA ?>">
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
    