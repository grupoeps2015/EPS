<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Pensum</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <?php if($_SESSION["rol"]==ROL_ADMINISTRADOR):?>
                            <a href="<?php echo BASE_URL ?>general/seleccionarCentroUnidad/gestionPensum/listadoPensum">
                                Regresar
                            </a>
                            <?php else:?>
                            <a href="<?php echo BASE_URL; ?>gestionPensum/inicio">
                                Regresar
                            </a>
                            <?php endif;?>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <?php if($this->permisoAgregar == PERMISO_CREAR): ?>
                        <i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/agregarPensum">
                                Agregar Pensum
                            </a>
                        </i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/listadoPensum">
            <div id="divPensum" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbPensum" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Carrera</th>
                                <th style="text-align:center; width: 250px;">Descripción</th>
                                <th style="text-align:center; width: 150px;">Tipo</th>
                                <th style="text-align:center; width: 150px;">Fecha Inicial</th>
                                <th style="text-align:center; width: 150px;">Fecha Final</th>
                                <th style="text-align:center; width: 80px;">Duración<br/>(ciclos)</th>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <th style="text-align:center; width: 50px;"></th>
                                <?php endif;?>
                                <?php if($this->permisoGestionCursosPensum == PERMISO_GESTIONAR): ?>
                                <th style="text-align:center; width: 50px;"></th>
                                <?php endif;?>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center; width: 50px;"></th>
                                <?php endif;?>
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
                                        <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if ((strcmp($this->lstPensum[$i]['estado'], 'Activo') == 0)): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/finalizarVigenciaPensum/' . $this->lstPensum[$i]['id'] . '/-1' ?>">Desactivar</a>
                                            <?php else : ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/activarPensum/' . $this->lstPensum[$i]['id'] ?>">Activar</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        </td>
                                        <?php if($this->permisoGestionCursosPensum == PERMISO_GESTIONAR): ?>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if (strcmp($this->lstPensum[$i]['estado'], 'Activo') == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/gestionCursoPensum/' . $this->lstPensum[$i]['id'] . '/' . $this->lstPensum[$i]['idcarrera']  ?>">Registrar cursos</a>
                                            <?php else : ?>

                                            <?php endif; ?>

                                        </td>
                                        <?php endif; ?>
                                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if (strcmp($this->lstPensum[$i]['estado'], 'Activo') == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/actualizarPensum/' . $this->lstPensum[$i]['id'] ?>">Actualizar</a>
                                            <?php else : ?>

                                            <?php endif; ?>
                                        
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>