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
                            <a href="<?php echo BASE_URL; ?>gestionHorario/seleccionarCicloCurso/<?php echo $this->id;?>">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL?>gestionHorario/agregarHorario'>
                            <i class="fa fa-2x fa-clock-o wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkNuevoHor" href="#">Agregar Horario</a>
                            </i>
                            <input type="hidden" name='slSec' value="<?php if(isset($this->idcurso)) echo $this->idcurso;?>"/>
                            <input type="hidden" name='hdCentroUnidad' value="<?php if(isset($this->id)) echo $this->id;?>"/>
                            <input type="hidden" name='slCiclo' value="<?php if(isset($this->idciclo)) echo $this->idciclo;?>"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <div id="divCarreras" class="form-group" >
            <div style="margin-left: 10%; margin-right: 10%">
                <table id="tbHorarios" border="2">
                    <thead>
                        <tr>
                            <th style="text-align:center">Jornada</th>
                            <th style="text-align:center">Duraci&oacute;n</th>
                            <th style="text-align:center">D&iacute;a</th>
                            <th style="text-align:center">Inicio - Fin</th>
                            <th style="text-align:center">Edificio</th>
                            <th style="text-align:center">Sal&oacute;n</th>
                            <th style="text-align:center">Catedr&aacute;tico</th>
                            <th style="text-align:center">&nbsp;</th>
                            <th style="text-align:center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($this->lstHor) && count($this->lstHor)): ?>
                        <?php for($i =0; $i < count($this->lstHor); $i++) : ?>
                        <tr>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['jornada']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['duracion']." minutos"; ?></td>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['dia']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['inicio']." - ".$this->lstHor[$i]['fin']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['edificio']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstHor[$i]['salon']; ?></td>
                            <td style="text-align: center">
                            <?php if($this->lstHor[$i]['primernombre'] != ""){echo $this->lstHor[$i]['primernombre']." ";} ?>
                            <?php if($this->lstHor[$i]['segundonombre'] != ""){echo $this->lstHor[$i]['segundonombre']." ";} ?>
                            <?php if($this->lstHor[$i]['primerapellido'] != ""){echo $this->lstHor[$i]['primerapellido']." ";} ?>
                            <?php if($this->lstHor[$i]['segundoapellido'] != ""){echo $this->lstHor[$i]['segundoapellido'];} ?>
                            </td>
                            <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionPensum/actualizarCarrera/' . $this->lstHor[$i]['idhorario'];?>">Modificar</a></td>
                            <td style="text-align: center;">
                                <?php if(strcmp($this->lstHor[$i]['estado'], 'Activo') == 0): ?>
                                <a href="<?php echo BASE_URL . 'gestionHorario/eliminarHorario/-1/' . $this->lstHor[$i]['idhorario'];?>">Desactivar</a>
                                <?php else : ?>
                                <a href="<?php echo BASE_URL . 'gestionHorario/eliminarHorario/1/' . $this->lstHor[$i]['idhorario'] ?>">Activar</a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endfor;?>
                    <?php else : ?>
                    <?php endif;?>
                    </tbody>
                </table>
                <br />
            </div>
        </div>
    </div>   
</section>