<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Extensiones</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <?php if(isset($this->vieneDeUnidad)): ?>
                        <i class="fa fa-2x fa-home wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>/login/inicio">
                                Inicio
                            </a>
                        </i>
                        <?php else: ?>
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionCentroUnidad/listadoUnidades/<?php echo $this->id ?>">
                                Regresar
                            </a>
                        </i>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <?php if($this->permisoAgregar == PERMISO_CREAR): ?>
                    <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL ?>gestionCentroUnidad/agregarExtension/<?php echo $this->id ?>'>
                        <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a id="linkNuevoExt" href="#">Agregar Extensi&oacute;n</a>
                        </i>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frExtensiones" method="post" action="">
            <div id="divExtensiones" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbExtensiones" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Estado</th>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center">&nbsp;</th>
                                <?php endif;?>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <th style="text-align:center">&nbsp;</th>
                                <?php endif;?>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center">&nbsp;</th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($this->lstExt) && count($this->lstExt)): ?>
                                <?php for ($i = 0; $i < count($this->lstExt); $i++) : ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $this->lstExt[$i]['nombre']; ?></td>
                                        <td style="text-align: center"><?php echo $this->lstExt[$i]['estado']; ?></td>
                                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                        <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionCentroUnidad/actualizarExtension/' . $this->lstExt[$i]['id']; ?>">Modificar</a></td>
                                        <?php endif; ?>
                                        <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                        <td style="text-align: center;">
                                            <?php if (strcmp($this->lstExt[$i]['estado'], 'Activo') == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionCentroUnidad/eliminarExtension/-1/' . $this->lstExt[$i]['id']; ?>">Desactivar</a>
                                            <?php else : ?>
                                                <a href="<?php echo BASE_URL . 'gestionCentroUnidad/eliminarExtension/1/' . $this->lstExt[$i]['id']; ?>">Activar</a>
                                            <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                        <td style="text-align: center;">
                                            <a href="<?php echo BASE_URL . 'gestionCentroUnidad/asignarAreaCarrera/' . $this->lstExt[$i]['id']; ?>">Asignar Areas</a>
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