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
                <h2 class="section-heading">Activar Usuario</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
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
            </div>
        </div>
    </div>
</section>
