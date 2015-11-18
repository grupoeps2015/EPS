<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de notas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>/general/seleccionarCentroUnidad/gestionNotas">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center" style="display:none;">
                    <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR): ?>
                    <div class="service-box">
                            <i class="fa fa-2x fa-pinterest wow bounceIn text-primary" data-wow-delay=".2s">
                                <a href="#">Ingresar Equivalencia</a>
                            </i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6 text-center" style="display:none;">
                    <div class="service-box">
                        <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR): ?>
                        <form method='post' name='frmPost' id='frmPost' action='<?php echo BASE_URL?>gestionParametro/parametroGeneral'>
                            <i class="fa fa-2x fa-paperclip wow bounceIn text-primary" data-wow-delay=".2s">
                                <a id="linkNuevoPar" href="#">Ingresar Suficiencia</a>
                            </i>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="container">
        <div style="margin-left: 10%; margin-right: 10%">
            <h4 class="text-center text-warning">Listado de catedr&aacute;ticos registrados para<br/> <?php echo '"' . $this->infoCentroUnidad[0]['nombreunidad'] . '" en "' . $this->infoCentroUnidad[0]['nombrecentro'] . '"'?></h4>
            <br/>
            <table id="tbCatedraticos" border="2">
                <thead>
                    <tr>
                        <th style="text-align:center">Registro</th>
                        <th style="text-align:center">Nombre</th>
                        <th style="text-align:center">Tipo</th>
                    <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                        <th style="text-align:center">Ingresar Notas</th>
                        <th style="text-align:center">Actividades</th>
                    <?php endif;?>
                    </tr>
                </thead>
                <tbody id="infoTabla">
                <?php if (isset($this->lstCat) && count($this->lstCat)): ?>
                    <?php for ($i = 0; $i < count($this->lstCat); $i++) : ?>
                    <tr>
                        <td style="text-align: center"><?php echo $this->lstCat[$i]['registro']; ?></td>
                        <td style="text-align: center"><?php echo $this->lstCat[$i]['nombrecompleto']; ?></td>
                        <td style="text-align: center"><?php echo $this->lstCat[$i]['tipodocente']; ?></td>
                        <?php if($this->permisoModificar == PERMISO_MODIFICAR): ?>
                        <td style="text-align: center">
                            <a href="<?php echo BASE_URL?>gestionNotas/cursosXDocente/<?php echo $this->lstCat[$i]['usuario']?>/<?php echo $this->id;?>">
                                Ver Cursos
                            </a>
                        </td>
                        <td style="text-align: center">
                            <a href="<?php echo BASE_URL?>gestionNotas/actividades/<?php echo $this->lstCat[$i]['usuario']?>/<?php echo $this->id;?>">
                                Ver/Crear
                            </a>
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