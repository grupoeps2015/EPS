<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Horarios</h2>
                <hr class="primary">
                <h4 class="section-heading"><?php if(isset($this->curso)) echo $this->curso;?></h4>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionHorario/agregarHorario">
                                Agregar Horario
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frCarreras" method="post" action="<?php echo BASE_URL; ?>gestionHorario/agregarHorario">
            <div id="divCarreras" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbCarreras" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Jornada</th>
                                <th style="text-align:center">Duraci&oacute;n</th>
                                <th style="text-align:center">Hora Inicio</th>
                                <th style="text-align:center">Hora Fin</th>
                                <th style="text-align:center">Edificio</th>
                                <th style="text-align:center">Sal&oacute;n</th>
                                <th style="text-align:center">Catedr&aacute;tico</th>
                                <th style="text-align:center">&nbsp;</th>
                                <th style="text-align:center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCar) && count($this->lstCar)): ?>
                            <?php for($i =0; $i < count($this->lstCar); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstCar[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCar[$i]['estado']; ?></td>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionPensum/actualizarCarrera/' . $this->lstCar[$i]['id'];?>">Modificar</a></td>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstCar[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionPensum/eliminarCarrera/-1/' . $this->lstCar[$i]['id'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionPensum/eliminarCarrera/1/' . $this->lstCar[$i]['id'] ?>">Activar</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endfor;?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" style="text-align: center">No hay informaci&oacute;n disponible.</td>
                            </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>