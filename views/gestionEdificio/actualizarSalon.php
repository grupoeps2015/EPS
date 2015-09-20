<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Sal&oacute;n</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionEdificio/gestionSalon/<?php echo $this->idEdificio;?>">
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

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <form id="frSalones" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/actualizarSalon/<?php echo $this->id; ?>/<?php echo $this->idEdificio ?>">
                    <div id="divSalones" class="form-group" align="center">
                        <div class="col-md-6 col-md-offset-3">
                            <table class="text-primary table-hover">
                                <tr>
                                    <td colspan="7">Nombre:   
                                                <input type="text" id="txtNombre" name="txtNombre" style="width: 400px;" class="form-control input-lg" value="<?php if(isset($this->datosSal)) {echo $this->datosSal[0]['nombre'];}?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">Nivel:   
                                                <input type="number" id="txtNivel" name="txtNivel" style="width: 400px;" class="form-control input-lg" value="<?php if(isset($this->datosSal)) {echo $this->datosSal[0]['nivel'];}?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">Capacidad:   
                                                <input type="number" id="txtCapacidad" name="txtCapacidad" style="width: 400px;" class="form-control input-lg" value="<?php if(isset($this->datosSal)) {echo $this->datosSal[0]['capacidad'];}?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                  
                                    <td colspan="3">
                                        <input type="submit" id="btnActualizarSalon" name="btnActualizarSalon" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
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