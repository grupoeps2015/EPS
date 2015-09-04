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
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de edificios</h3>
                    <p class="text-muted">Capacidad de salones y gestion de uso</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>gestionUsuario">Gesti&oacute;n de usuarios</a></h3>
                    <p class="text-muted">Directores, Control Academico, Catedraticos y Estudiantes</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>gestionParametro">Parametrizaci&oacute;n</a></h3>
                    <p class="text-muted">Modulo de parametrizaci&oacute;n diseñado para administradores</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-mortar-board wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de Unidades Acad&eacute;micas</h3>
                    <p class="text-muted">Faculades, Escuelas y Centros Regionales</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-navicon wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>gestionCurso">Gesti&oacute;n de Cursos</a></h3>
                    <p class="text-muted">Creaci&oacute; y actualizaci&oacute;n de cursos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-wrench wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>gestionNotas">Gesti&oacute;n de Notas</a></h3>
                    <p class="text-muted">Ingreso y consulta de notas por curso</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-shekel wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de Pensum de estudios</h3>
                    <p class="text-muted">Creaci&oacute; y actualizaci&oacute;n de pensum seg&uacute;n carreras</p>
                </div>
            </div>
        </div>
    </div>
</section>