<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Par&aacute;metros Generales</h2>
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
                <div class="col-lg-1 col-md-6 text-cenater"></div>
                <div class="col-lg-4 col-md-6 text-center">
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
            <div id="divParametros" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbParametros" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Par&aacute;metro</th>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Valor</th>
                                <!--<th style="text-align:center">Extensi&oacute;n</th>-->
                                <th style="text-align:center">Tipo par&aacute;metro</th>
                                <th style="text-align:center">Estado</th>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <th style="text-align:center">Modificar</th>  
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstPar) && count($this->lstPar)): ?>
                            <?php for($i =0; $i < count($this->lstPar); $i++) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $this->lstPar[$i]['codigoparametro']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstPar[$i]['nombreparametro']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstPar[$i]['valorparametro']; ?></td>
                                <!--<td style="text-align: center"><?php echo $this->lstPar[$i]['codigoparametro']; ?></td>-->
                                <td style="text-align: center"><?php echo $this->lstPar[$i]['nombretipoparametro']; ?></td>
                                <td style="text-align: center">
                                    <?php if($this->permisoEliminar == PERMISO_ELIMINAR): ?>
                                        <?php if(strcmp($this->lstPar[$i]['estadoparametro'], '1') == 0): ?>
                                            <a href="<?php echo BASE_URL . 'gestionParametro/eliminarParametro/-1/' . $this->lstPar[$i]['parametro'];?>">Desactivar</a>
                                            <?php else : ?>
                                            <a href="<?php echo BASE_URL . 'gestionParametro/eliminarParametro/1/' . $this->lstPar[$i]['parametro'];?>">Activar</a>
                                        <?php endif;?>
                                    <?php else : ?>
                                            <?php if(strcmp($this->lstPar[$i]['estadoparametro'], '1') == 0): ?>
                                                Activo
                                            <?php else : ?>
                                                Inactivo
                                            <?php endif;?>
                                    <?php endif;?>
                                </td>
                                <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionParametro/actualizarParametro/' . $this->lstPar[$i]['parametro'];?>">Modificar</a></td>
                                <?php endif;?>
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