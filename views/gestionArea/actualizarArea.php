<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Area</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionArea/listadoArea">
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
                <form id="frArea" method="post" action="<?php echo BASE_URL; ?>gestionArea/actualizarArea/<?php echo $this->id; ?>">
                    <div id="divArea" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table class="text-primary table-hover">
                                <tr>
                                    <td colspan="7">Nombre:   
                                                <input type="text" id="txtNombre" name="txtNombre" style="width: 700px;" class="form-control input-lg" value="<?php if(isset($this->datosEdif)) {echo $this->datosEdif[0]['_nombre'];}?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Descripción:
                                        <textarea name="txtDescripcion" id="txtDescripcion" name="txtDescripcion" style="width: 700px; resize: none;" rows="3"><?php if(isset($this->datosEdif)) {echo $this->datosEdif[0]['_descripcion'];}?></textarea>
                                        
                                        <br/>
                                        <br/>
                                    </td>         
                                    
                                </tr>
                                <tr>
                                  
                                    <td colspan="3">
                                        <input style="width: 30%; float: right; margin-right: 75px;" type="submit" id="btnActualizarArea" name="btnActualizarArea" value="Actualizar" class="btn btn-danger btn-lg btn-block">
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