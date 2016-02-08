<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading"><?php if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {echo "Selecci&oacute;n de Carrera";}?></h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="javascript:window.history.go(-1)">Volver</a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <?php if(isset($this->busquedaID)): ?>
                    <div class="service-box">
                        <i class="fa fa-2x fa-search wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="#" class="h2" data-wow-delay=".1s" data-toggle="modal" data-target="#myModal">Buscar por ID</a>
                        </i>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <br/>
        
    <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO): ?>
    
    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?><?php if (isset($this->url)) echo $this->url; ?>">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>Carrera: </h4><br />
                        </td>
                        <td style="width: 38%">
                            <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                            <?php if (isset($this->lstCarreras) && count($this->lstCarreras)): ?>
                                    <option value="">-- Carrera --</option>
                                    <?php for ($i = 0; $i < count($this->lstCarreras); $i++) : ?>
                                        <option value="<?php echo $this->lstCarreras[$i]['codigo']; ?>">
                                            <?php echo $this->lstCarreras[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- Carrera --</option>
                            <?php endif; ?>
                            </select><br />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Seleccionar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <?php if(isset($this->busquedaID)): ?>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h2 class="text-center">Buscar boleta de asignaci&oacute;n</h2>
                </div>
                <div class="modal-body row">
                    <form id="frmGenerales" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" method="post" action="<?php echo BASE_URL; ?><?php if (isset($this->url)) echo $this->url; ?>">
                        <div class="form-group">
                            <table align="center">
                                <tr>
                                    <td colspan="3"><br />ID:<br />
                                    <input id="txtIDBoleta" name="txtIDBoleta" type="text" min="0" class="form-control input-lg" value="<?php /*echo $this->infoGeneral[0]['dircorta']*/ ?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="width: 45%">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><br/>
                                        <input type="submit" id="btnGenerales" name="btnGenerales" value="Buscar boleta" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="hdEnvio" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>