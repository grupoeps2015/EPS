<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Cursos Asignados</h2>
                 <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['nombreestudiante'];?></h3>
                <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['carnet']; ?></h3>
                <?php endif;?>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>login/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        
            <div id="divAsignaciones" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbAsignaciones" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Codigo</th>
                                <th style="text-align:center; width: 250px;">Nombre</th>
                                <th style="text-align:center; width: 100px;">Seccion</th>
                                <th style="text-align:center; width: 200px;">Fecha Asignacion</th>
                                <th style="text-align:center; width: 200px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                                <?php for ($i = 0; $i < count($this->lstAsignaciones); $i++) : ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $this->lstAsignaciones[$i]['codigo']; ?></td>
                                        <td style="text-align: center;"><?php echo $this->lstAsignaciones[$i]['nombre']; ?></td>
                                        <td style="text-align: center;"><?php echo $this->lstAsignaciones[$i]['seccion']; ?></td>
                                        <td style="text-align: center;"><?php echo $this->lstAsignaciones[$i]['fecha']; ?></td>
                                        <td style="text-align: center;">
                                            <?php if (strcmp($this->lstAsignaciones[$i]['estado'], 'Activo') == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionDesasignacion/detalleAsignacion/' . $this->lstAsignaciones[$i]['asignacion'];?>">Detalle</a>
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
    </div>   
</section>

