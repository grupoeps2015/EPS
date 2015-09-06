<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Cursos</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>general/seleccionarCentroUnidad/gestionCurso">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL?>gestionCurso/agregarCurso'>
                            <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkNuevoUsr" href="#">Agregar Curso</a>
                            </i>
                            <input type="hidden" name='hdCentroUnidad' value="<?php echo $this->id;?>"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frCursos" method="post" action="<?php echo BASE_URL; ?>gestionCurso/agregarCurso">
            <div id="divCursos" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbCursos" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Codigo</th>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Tipo</th>
                                <th style="text-align:center">Traslape</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">&nbsp;</th>
                                <th style="text-align:center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCur) && count($this->lstCur)): ?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['tipocurso']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['traslape']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['estado']; ?></td>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionCurso/actualizarCurso/' . $this->lstCur[$i]['id'];?>">Modificar</a></td>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstCur[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionCurso/eliminarCurso/-1/' . $this->lstCur[$i]['id'] . '/' . $this->id;?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionCurso/eliminarCurso/1/' . $this->lstCur[$i]['id'] . '/' . $this->id;?>">Activar</a>
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