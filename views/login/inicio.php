<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Bienvenido <?php echo " " . $_SESSION["nombre"]; ?></h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <!-- Menu Opcion 1 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3>
                        <a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionUsuario">
                                Gesti&oacute;n de Usuarios
                        </a>
                    </h3>
                    <p class="text-muted">Directores, Control Acad&eacute;mico, Catedr&aacute;ticos y Estudiantes</p>
                </div>
            </div>
            
            <!-- Menu Opcion 2 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-mortar-board wow bounceIn text-primary"></i>
                    <h3>
                        <a href="<?php echo BASE_URL; ?>gestionCentroUnidad">
                            Gesti&oacute;n de Unidades Acad&eacute;micas
                        </a>
                    </h3>
                    <p class="text-muted">Facultades, Escuelas y Centros Regionales</p>
                </div>
            </div>
            
            <!-- Menu Opcion 3 -->
                        <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3>
                        <a href="<?php echo BASE_URL; ?>gestionEdificio/listadoEdificio">
                            Gesti&oacute;n de Edificios
                        </a>                        
                    </h3>
                    <p class="text-muted">Capacidad de salones y gesti&oacute;n de uso</p>
                </div>
            </div>
            
            <!-- Menu Opcion 4 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionParametro">Parametrizaci&oacute;n</a></h3>
                    <p class="text-muted">M&oacute;dulo de parametrizaci&oacute;n diseñado para administradores</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Menu Opcion 8 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-shekel wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>gestionPensum/inicio">Gesti&oacute;n de P&eacute;nsum de estudios</a></h3>
                    <p class="text-muted">Creaci&oacute;n y actualizaci&oacute;n de p&eacute;nsums seg&uacute;n carreras</p>
                </div>
            </div>
            
            <!-- Menu Opcion 6 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-navicon wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionCurso">Gesti&oacute;n de Cursos</a></h3>
                    <p class="text-muted">Creaci&oacute;n y actualizaci&oacute;n de cursos</p>
                </div>
            </div>
            
            <!-- Menu Opcion 7 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-calendar wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionHorario/seleccionarCicloCurso">Gesti&oacute;n de Horarios</a></h3>
                    <p class="text-muted">Asignaci&oacute;n de salones, catedr&aacute;ticos y horarios de clase</p>
                </div>
            </div>
            
            <!-- Menu Opcion 8 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-wrench wow bounceIn text-primary"></i>
                    <h3>
                        <a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionNotas">Gesti&oacute;n de Notas</a>
                    </h3>
                    <p class="text-muted">Ingreso y consulta de notas por curso</p>
                </div>
            </div>
        </div>
    </div>
</section>