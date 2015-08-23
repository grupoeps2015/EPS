<?php session_start() ?>
<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">
                    Actualizar Informacion Personal<br/>
                    - Estudiante -
                </h2>
                <!--<p><?php if (isset($this->datosUsr)) print_r($this->datosUsr); ?></p>  ahora le diremos que muestre datosUsr -->
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>admCrearUsuario">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <br/><br/><br/>
                <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/actualizarUsuario">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center">
                                <tr>
                                    <td colspan="3" style="text-align: right">Departamento: </td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">
                                        <?php if(isset($this->deptos) && count($this->deptos)): ?>
                                        <select id="slDeptos" name="slDeptos" class="form-control input-lg">
                                            <option value="">- Departamentos -</option>
                                            <?php for($i =0; $i < count($this->deptos); $i++) : ?>
                                            <option value="<?php echo $this->deptos[$i]['codigo'];?>">
                                                <?php echo $this->deptos[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right">Municipio: </td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">
                                        <select id="slMunis" name="slMunis" class="form-control input-lg">
                                            <option value="" disabled>- Municipios -</option>
                                        </select>
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
    <br />

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de edificios</h3>
                    <p class="text-muted">Capacidad de salones y gestion de uso</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-mortar-board wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de Unidades Acad&eacute;micas</h3>
                    <p class="text-muted">Faculades, Escuelas y Centros Regionales</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3>Gesti&oacute;n de personal</h3>
                    <p class="text-muted">Directores, Control Academico, Catedraticos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Gesti&oacute;n de estudiantes</h3>
                    <p class="text-muted">Alumnos regulares</p>
                </div>
            </div>
        </div>
    </div>
</section>