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
                <h2 class="section-heading">Usuarios</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
            </div>
        </div>
    </div>
    
    <div>
        <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario">
            <div id="divEstudiantes" class="form-group" >
                <div>
                    <table id="tbUsuarios" border="2">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Carnet/Registro</th>
                                <th>Nombre Usuario</th>
                                <th>Rol</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstUsr) && count($this->lstUsr)): ?>
                            <?php for($i =0; $i < count($this->lstUsr); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['id']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['registro']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['rol']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['correo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['estado']; ?></td>
                                <td style="text-align: center;"><a href="#">Modificar</a></td>
                                <td style="text-align: center;"><a href="#">Activar/Desactivar</a></td>
                            </tr>
                            <?php endfor;?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" style="text-align: center">No hay informacion disponible</td>
                            </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>
    
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