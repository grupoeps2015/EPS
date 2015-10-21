<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Secciones</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>gestionCurso">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <?php if($this->permisoAgregar == PERMISO_CREAR): ?>
                        <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL?>gestionCurso/agregarSeccion'>
                            <i class="fa fa-2x fa-bell-o wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkSeccionNueva" href="#">Agregar Secci&oacute;n</a>
                            </i>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frSecciones" method="post" action="<?php echo BASE_URL; ?>gestionCurso/agregarSeccion">
            <div id="divSecciones" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbSecciones" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Curso</th>
                                <th style="text-align:center">Tipo</th>
                                <th style="text-align:center">Estado</th>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center">&nbsp;</th>
                                <?php endif;?>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <th style="text-align:center">&nbsp;</th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstSec) && count($this->lstSec)): ?>
                            <?php for($i =0; $i < count($this->lstSec); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstSec[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstSec[$i]['curso']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstSec[$i]['tiposeccion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstSec[$i]['estado']; ?></td>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <td style="text-align: center;">
                                    <a href="<?php echo BASE_URL . 'gestionCurso/actualizarSeccion/' . $this->lstSec[$i]['id'];?>">
                                        Modificar
                                    </a>
                                </td>
                                <?php endif;?>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstSec[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionCurso/eliminarSeccion/-1/' . $this->lstSec[$i]['id'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionCurso/eliminarSeccion/1/' . $this->lstSec[$i]['id'];?>">Activar</a>
                                    <?php endif;?>
                                </td>
                                <?php endif;?>
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