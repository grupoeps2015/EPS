<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Pensum</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>pensum/agregarPensum">
                                Agregar Pensum
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>pensum/agregarPensum">
            <div id="divPensum" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbEdificios" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Carrera</th>
                                <th style="text-align:center; width: 250px;">Tipo</th>
                                <th style="text-align:center; width: 200px;">Descripción</th>
                                <th style="text-align:center; width: 100px;">Vigencia</th>
                                <th style="text-align:center; width: 100px;">Duración(años)</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($this->lstPensum) && count($this->lstPensum)): ?>
                             
                            <?php print_r($this->lstPensum); ?>
                                <?php for ($i = 0; $i < count($this->lstPensum); $i++) : ?>
                                    <tr>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['carrera']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['tipo']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['inicioVigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['duracionAnios']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['finVigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['descripcion']; ?></td>
                                    </tr>
                                <?php endfor; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" style="text-align: center">No hay informaci&oacute;n disponible.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>