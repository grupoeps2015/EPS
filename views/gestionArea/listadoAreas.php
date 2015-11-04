<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Areas Registradas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>gestionPensum/inicio">
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
                        <i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionArea/agregarArea">
                                Agregar Area
                            </a>
                        </i>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frAreas" method="post" action="<?php echo BASE_URL; ?>gestionArea/agregarArea">
            <div id="divAreas" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbAreas" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Nombre</th>
                                <th style="text-align:center; width: 250px;">Descripción</th>
                                <th style="text-align:center; width: 100px;">Estado</th>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center; width: 100px;">&nbsp;</th>
                                <?php endif;?>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <th style="text-align:center; width: 200px;">&nbsp;</th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstArea) && count($this->lstArea)): ?>
                            
                            <?php for($i =0; $i < count($this->lstArea); $i++) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $this->lstArea[$i]['_nombre']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstArea[$i]['_descripcion']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstArea[$i]['_estado']; ?></td>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <td style="text-align: center; padding-right: 20px;"><a href="<?php echo BASE_URL . 'gestionArea/actualizarArea/' . $this->lstArea[$i]['_id']; ?>">Modificar</a></td>
                                <?php endif;?>
                                <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                <td style="text-align: center;">
                                     <?php if(strcmp($this->lstArea[$i]['_estado'], 'Activo') == 0): ?>
                                      
                                    <a href="<?php echo BASE_URL . 'gestionArea/activarDesactivarArea/-1/' . $this->lstArea[$i]['_id'];?>">Desactivar</a>
                                    <?php else : ?>
                                     
                                    <a href="<?php echo BASE_URL . 'gestionArea/activarDesactivarArea/1/' . $this->lstArea[$i]['_id'] ?>">Activar</a>
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