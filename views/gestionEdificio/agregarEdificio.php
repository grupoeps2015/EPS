<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Edificio</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionEdificio/listadoEdificio">
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
                <form id="frEdificios" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/agregarEdificio">
                    <div id="divEdificios" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table style="margin-top: 30px;">
                                <tr>
                                    <td colspan="3">
                                        *Nombre Edificio:
                                        <input type="text" id="txtNombre" name="txtNombre" style="width: 700px;" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Descripción:
                                        <textarea name="txtDescripcion" id="txtDescripcion" style="width: 700px; resize: none;" rows="3"><?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?></textarea>
                                        
                                        <br/>
                                    </td>
                                </tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" id="btnAgregarEdificio" style="width: 200px; margin-top: 30px; float: right; margin-right: 80px;" 
                                               name="btnAgregarEdificio" value="Nuevo Edificio" class="btn btn-danger btn-lg btn-block">
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