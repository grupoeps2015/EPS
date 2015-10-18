<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Salones</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>gestionEdificio/listadoEdificio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-2 col-md-4 text-center"></div>
                <div class="col-lg-4 col-md-8 text-center">
                    <div class="service-box">
                        <?php if($this->permisoAgregar == PERMISO_CREAR): ?>
                        <i class="fa fa-2x fa-upload wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionEdificio/agregarSalon/<?php echo $this->id;?>">
                                Agregar Salón
                            </a>
                        </i>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br/>
    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
                <form id="frSalones" method="post" action="<?php echo BASE_URL; ?>gestionSalon">
                    <div id="divSalones" class="form-group" >
                        <div align="center" style="margin-top: 10px; margin-left: 10%; margin-right: 10%;">
                            <table id="tbSalones" border="2" align="center">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; padding-right: 20px;">Nombre</th>
                                        <th style="text-align:center; padding-right: 20px;">Edificio</th>
                                        <th style="text-align:center; padding-right: 20px; ">Nivel</th>
                                        <th style="text-align:center; padding-right: 20px; ">Capacidad</th>
                                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                        <th style="text-align:center; padding-right: 20px; ">&nbsp;</th>
                                        <?php endif;?>
                                        <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                        <th style="text-align:center; padding-right: 20px; ">&nbsp;</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($this->lstSalones) && count($this->lstSalones)): ?>
                                        
                                        <?php for ($i = 0; $i < count($this->lstSalones); $i++) : ?>
                                            <tr>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstSalones[$i]['nombre']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstSalones[$i]['nombreedificio']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstSalones[$i]['nivel']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstSalones[$i]['capacidad']; ?></td>
                                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                                <td style="text-align: center; padding-right: 20px;"><a href="<?php echo BASE_URL . 'gestionEdificio/actualizarSalon/' . $this->lstSalones[$i]['salon'] . '/' . $this->id; ?>">Modificar</a></td>
                                                <?php endif; ?>
                                                <td style="text-align: center; padding-right: 20px;">
                                                    <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                                        <?php if (strcmp($this->lstSalones[$i]['estado'], '1') == 0): ?>

                                                            <a href="<?php echo BASE_URL . 'gestionEdificio/eliminarSalon/-1/' . $this->lstSalones[$i]['salon'] . '/' . $this->id; ?>">Desactivar</a>
                                                        <?php else : ?>

                                                            <a href="<?php echo BASE_URL . 'gestionEdificio/eliminarSalon/1/' . $this->lstSalones[$i]['salon'] . '/' . $this->id; ?>">Activar</a>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                            <?php if (strcmp($this->lstSalones[$i]['estado'], '1') == 0): ?>
                                                                Activo
                                                            <?php else : ?>
                                                                Inactivo
                                                            <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
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
        </div>
    </div>
</section>