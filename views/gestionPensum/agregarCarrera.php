<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Carrera</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionPensum/listadoCarrera">
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
                <form id="frCarreras" method="post" action="<?php echo BASE_URL; ?>gestionPensum/agregarCarrera">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td colspan="3" width="50px;">
                                        *Código:
                                        <input type="text" id="txtCodigo" name="txtCodigo" class="form-control input-lg" value="<?php if(isset($this->datos['txtCodigo'])) echo $this->datos['txtCodigo']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" width="100%">
                                        *Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" id="btnAgregarCar" name="btnAgregarCar" value="Nueva Carrera" class="btn btn-danger btn-lg btn-block">
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