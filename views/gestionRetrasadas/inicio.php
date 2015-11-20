<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gestión de retrasadas</h2>
                <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['nombreestudiante']; ?></h3>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['carnet']; ?></h3>
                <?php endif; ?>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>estudiante/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-9 text-center">
                <div class="service-box">
                    <i class="fa fa-2x fa-clipboard wow bounceIn text-primary">
                        <a href="<?php echo BASE_URL . 'general/seleccionarCarreraEstudiante/gestionRetrasadas/listadoAsignaciones/'?>">Generaci&oacute;n de orden de pago</a>
                    </i>
                </div> 
            </div>
            <div class="col-lg-6 col-md-9 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-book wow bounceIn text-primary" data-wow-delay=".1s">
                            <a href="<?php echo BASE_URL . 'general/seleccionarCarreraEstudiante/asignacion/indexRetrasada'?>">Asignaci&oacute;n de retrasadas</a>
                        </i>
                    </div>
            </div>   
        </div>
    </div>
</section>
