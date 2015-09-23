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
                            <a href="<?php echo BASE_URL ?>gestionPensum/agregarPensum">
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
        <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/listadoPensum">
            <div id="divPensum" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbEdificios" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Carrera</th>
                                <th style="text-align:center; width: 250px;">Descripción</th>
                                <th style="text-align:center; width: 200px;">Tipo</th>
                                <th style="text-align:center; width: 100px;">Fecha Inicial</th>
                                <th style="text-align:center; width: 100px;">Fecha Final</th>
                                <th style="text-align:center; width: 100px;">Duración(años)</th>
                                <th style="text-align:center; width: 200px;"></th>
                                <th style="text-align:center; width: 150px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($this->lstPensum) && count($this->lstPensum)): ?>

                                <?php for ($i = 0; $i < count($this->lstPensum); $i++) : ?>
                                    <tr>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['carrera']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['descripcion']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['tipo']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['iniciovigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['finvigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['duracionanios']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if (strcmp($this->lstPensum[$i]['finvigencia'], null) == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/finalizarVigenciaPensum/' . $this->lstPensum[$i]['id'] ?>">Desactivar Pensum</a>
                                            <?php else : ?>
                                                Pensum desactivo
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if (strcmp($this->lstPensum[$i]['finvigencia'], null) == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/crearPensum/' . $this->lstPensum[$i]['id'] ?>">Registrar cursos</a>
                                            <?php else : ?>

                                            <?php endif; ?>

                                        </td>


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