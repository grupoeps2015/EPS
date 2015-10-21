<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Nueva Area</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
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
            <div id="divAreas" class="row">
                <form id="frAreas" method="post" action="<?php echo BASE_URL; ?>gestionArea/agregarArea">
                    <div id="divAreas" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table style="margin-top: 30px;">
                                <tr>
                                    <td colspan="3">
                                        *Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" style="width: 700px;" class="form-control input-lg" value="">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Descripción:
                                        <br/>
                                        <textarea name="txtDescripcion" id="txtDescripcion" style="width: 700px; resize: none;" rows="3"></textarea>
                                        
                                        <br/>
                                    </td>
                                </tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" id="btnAgregarArea" style="width: 200px; margin-top: 30px; float: right; margin-right: 80px;" 
                                               name="btnAgregarArea" value="Nueva Area" class="btn btn-danger btn-lg btn-block">
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