<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Centros Universitarios</h2>
                <hr class="primary">
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
                        <?php if($this->permisoAgregar == PERMISO_CREAR): ?>
                        <i class="fa fa-2x fa-university wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad/agregarCentro">
                                Agregar Centro
                            </a>
                        </i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="container">
        <div style="margin-left: 10%; margin-right: 10%">
            <table id="tbCentrosRegionales" border="2" align="center">
                <thead>
                    <tr>
                        <th style="text-align:center;">C&oacute;digo</th>
                        <th style="text-align:center;">Nombre</th>
                        <th style="text-align:center;">Direcci&oacute;n</th>
                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                        <th style="text-align:center;">&nbsp;</th>
                        <?php endif;?>
                        <?php if($this->permisoGestionUnidad == PERMISO_GESTIONAR): ?>
                        <th style="text-align:center;">&nbsp;</th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($this->lstCentros) && count($this->lstCentros)): ?>
                    <?php for($i =0; $i < count($this->lstCentros); $i++) : ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $this->lstCentros[$i]['centro']; ?></td>
                        <td style="text-align: center;"><?php echo $this->lstCentros[$i]['nombre']; ?></td>
                        <td style="text-align: center;"><?php echo $this->lstCentros[$i]['direccion']; ?></td>
                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                        <td style="text-align: center;">
                            <a href="<?php echo BASE_URL . 'gestionCentroUnidad/actualizarCentro/' . $this->lstCentros[$i]['centro'];?>">Modificar</a>
                        </td>
                        <?php endif;?>
                        <?php if($this->permisoGestionUnidad == PERMISO_GESTIONAR): ?>
                        <td style="text-align: center;">
                            <a href="<?php echo BASE_URL . 'gestionCentroUnidad/listadoUnidades/' . $this->lstCentros[$i]['centro'];?>">Ver Unidades Acad&eacute;micas</a>
                        </td>
                        <?php endif;?>
                    </tr>
                    <?php endfor;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>   
    </div>
</section>