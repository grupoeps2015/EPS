<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n General de P&eacute;nsum</h2>
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
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionPensum/listadoCarrera">Gesti&oacute;n de carreras</a></h3>
                    <p class="text-muted">Carreras por Unidad Acad&eacute;mica y Centro Regional</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3><a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionPensum/listadoPensum">Gesti&oacute;n de p&eacute;nsums</a></h3>
                    <p class="text-muted">P&eacute;nsum de estudios por Carrera</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Gesti&oacute;n de requisitos</h3>
                    <p class="text-muted">Requisitos por Curso seg&uacute;n P&eacute;nsum</p>
                </div>
            </div>
        </div>
    </div>
</section>