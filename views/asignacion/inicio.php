<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignaciones</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
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
    <br/>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-file-text-o wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/general/seleccionarCarreraEstudiante/asignacion">Asignaci&oacute;n de cursos</a></h3>
                    <p class="text-muted">Asignaci&oacute;n de cursos por estudiante</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-file-text wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>aquiVaTuEnlaceMaythee">Desasignaci&oacute;n de cursos</a></h3>
                    <p class="text-muted">Desasignaci&oacute;n de cursos por estudiante</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-search wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/general/seleccionarCarreraEstudiante/asignacion/boletaAsignacion">Boletas de asignaci&oacute;n</a></h3>
                    <p class="text-muted">Consulta de boletas de asignaci&oacute;n por estudiante</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-star wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/general/seleccionarCarreraEstudiante/asignacion/notaAsignacion">Notas por asignaci&oacute;n</a></h3>
                    <p class="text-muted">Consulta de notas por asignaci&oacute;n</p>
                </div>
            </div>
        </div>
    </div>
</section>