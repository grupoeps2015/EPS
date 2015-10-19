<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Cursos por Pensum</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/listadoPensum">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 text-cenater"></div>
                <div class="col-lg-4 col-md-6 text-center">
                    
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL?>gestionPensum/agregarCursoPensum/<?php echo $this->idPensum?>/<?php echo $this->idCarrera;?>'>
                            <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkNuevoCursoPensum" href="#">Agregar Curso del Pensum</a>
                            </i>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
            <div id="divCursosPensum" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbCursosPensum" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Curso</th>
                                <th style="text-align:center">&Aacute;rea</th>
                                <th style="text-align:center">N&uacute;mero ciclo</th>
                                <th style="text-align:center">Tipo ciclo</th>
                                <th style="text-align:center">Creditos</th>
                                <th style="text-align:center">Prerrequisitos</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">Modificar</th>                               
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCurPensum) && count($this->lstCurPensum)): ?>
                            <?php for($i =0; $i < count($this->lstCurPensum); $i++) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $this->lstCurPensum[$i]['nombrecurso']; ?></td>
                                <td style="text-align: center; width: 8%;"><?php echo $this->lstCurPensum[$i]['nombrearea']; ?></td>
                                <td style="text-align: center; width: 8%;"><?php echo $this->lstCurPensum[$i]['numerociclo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCurPensum[$i]['nombretipociclo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCurPensum[$i]['creditos']; ?></td>
                                <td style="text-align: center;">
                                     <?php if(isset($this->lstCurPensum[$i]['prerrequisitos'])): ?>
                                        <a href="<?php echo BASE_URL . 'gestionPensum/crearPensum/' . $this->idPensum . '/' . $this->lstCurPensum[$i]['id'] . '/' . $this->idCarrera.'?prerrequisitos='.str_replace("\"","'", $this->lstCurPensum[$i]['prerrequisitos']);?>">Prerrequisitos</a></td>
                                        <?php else : ?>
                                        <a href="<?php echo BASE_URL . 'gestionPensum/crearPensum/' . $this->idPensum . '/' . $this->lstCurPensum[$i]['id'] . '/' . $this->idCarrera;?>">Prerrequisitos</a></td>
                                    <?php endif;?>
                                    
                                    
                                <td style="text-align: center">
                                    <?php if(strcmp($this->lstCurPensum[$i]['estado'], '1') == 0): ?>
                                        <a href="<?php echo BASE_URL . 'gestionPensum/eliminarCursoPensum/-1/' . $this->lstCurPensum[$i]['id'] . '/' . $this->idPensum  . '/' . $this->idCarrera;?>">Desactivar</a>
                                        <?php else : ?>
                                        <a href="<?php echo BASE_URL . 'gestionPensum/eliminarCursoPensum/1/' . $this->lstCurPensum[$i]['id'] . '/' . $this->idPensum . '/' . $this->idCarrera;?>">Activar</a>
                                    <?php endif;?>
                                </td>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionPensum/actualizarCursoPensum/' . $this->lstCurPensum[$i]['id'] . '/' . $this->idPensum . '/' . $this->idCarrera;?>">Modificar</a></td>
                            </tr>
                            <?php endfor;?>
                        <?php endif;?> 
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
    </div>   
</section>