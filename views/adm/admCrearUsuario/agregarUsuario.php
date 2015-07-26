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
                <form id="form1" method="post" action=="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario" class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                        Usuario:    <input type="text" name="txtUsuario" value="1" disabled="true" class="form-control input-lg">
                        Nombre:     <input type="text" name="txtNombre" class="form-control input-lg">
                        Correo:     <input type="text" name="txtCorreo" class="form-control input-lg">
                        Clave:      <input type="password" name="txtPass1" class="form-control input-lg">
                        Validar:    <input type="password" name="txtPass2" class="form-control input-lg">
                        Pregunta Secreta:   <input type="text" name="txtEstado" class="form-control input-lg">
                        Respuesta Secreta:  <input type="text" name="txtEstado" class="form-control input-lg">
                        Foto: <input type="text" name="txtEstado" class="form-control input-lg">
                        <input type="hidden" name="txtEstado" class="form-control input-lg">
                        <input type="hidden" name="txtFecha" class="form-control input-lg">
                        <input type="hidden" name="txtIntentos" class="form-control input-lg">
                        <input type="hidden" name="txtUnidadAcademica" class="form-control input-lg">

                    </div>
                    <br />
                    <div class="form-group">
                        <input type="submit" name="btnAgregar" value="Crear Nuevo" class="btn btn-danger btn-lg btn-block">
                    </div>
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