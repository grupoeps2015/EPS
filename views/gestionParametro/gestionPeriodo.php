<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Per&iacute;odos</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>gestionParametro">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <form method='post' name='frmPost' id='frmPost' action=''>
                            <i class="fa fa-2x fa-toggle-on wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkSeccionNueva" href="#">Agregar Per&iacute;odo</a>
                            </i>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frPeriodos" method="post" action="">
            <div id="divPeriodos" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbPeriodos" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">A&ntilde;o</th>
                                <th style="text-align:center">Ciclo</th>
                                <th style="text-align:center">Tipo</th>
                                <th style="text-align:center">Asignación</th>
                                <th style="text-align:center">Inicio</th>
                                <th style="text-align:center">Fin</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">&nbsp;</th>
                                <th style="text-align:center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstPer) && count($this->lstPer)): ?>
                            <?php for($i =0; $i < count($this->lstPer); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['anio']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['nombreciclo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['tipo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['asignacion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['inicio']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['fin']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPer[$i]['estado']; ?></td>
                                <td style="text-align: center;">
                                    <a href="<?php echo BASE_URL . 'gestionParametro/actualizarPeriodo/' . $this->lstPer[$i]['id'];?>">
                                        Modificar
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstPer[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionParametro/eliminarPeriodo/-1/' . $this->lstPer[$i]['id'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionParametro/eliminarPeriodo/1/' . $this->lstPer[$i]['id'];?>">Activar</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endfor;?>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>