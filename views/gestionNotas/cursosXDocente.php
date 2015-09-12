<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesi&oacute;n de notas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionNotas/index/<?php echo $this->idCentroUnidad?>">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box" style="display:none;">
                        <i class="fa fa-2x fa-forward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionNotas/actividades">
                                Crear Actividades
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table>
                    <tr>
                        <td>Registro:&nbsp;</td>
                        <td><?php echo $this->registroCat;?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $this->nombreCat;?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>