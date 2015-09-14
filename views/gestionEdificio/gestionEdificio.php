<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Edificios</h2>
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
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionEdificio/asignacionEdificio/<?php echo $this->id;?>">
                                Agregar Asignacion
                            </a>
                        </i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br/>
    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
                <form id="frEdificios" method="post" action="<?php echo BASE_URL; ?>gestionEdificios/asignacionEdificio">
                    <div id="divEdificios" class="form-group" >
                        <div align="center" style="margin-top: 10px; margin-left: 10%; margin-right: 10%;">
                            <table id="tbEdificios" border="2" align="center">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; padding-right: 20px;">Nombre Unidad Academica</th>
                                        <th style="text-align:center; padding-right: 20px;">Nombre Centro</th>
                                        <th style="text-align:center; padding-right: 20px; ">Jornada</th>
                                        <th style="text-align:center; padding-right: 20px; ">Estado</th>
                                        <th style="text-align:center; padding-right: 20px; ">&nbsp;</th>
                                        <th style="text-align:center; padding-right: 20px; ">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($this->lstEdificio) && count($this->lstEdificio)): ?>

                                        <?php for ($i = 0; $i < count($this->lstEdificio); $i++) : ?>
                                            <tr>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstEdificio[$i]['nombreunidadacademica']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstEdificio[$i]['nombrecentro']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstEdificio[$i]['jornada']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstEdificio[$i]['estado']; ?></td>
                                                <td style="text-align: center; padding-right: 20px;"><a href="<?php echo BASE_URL . 'gestionSeccion/actualizarEdificio/' . $this->lstEdificio[$i]['idEdificio']; ?>">Modificar</a></td>
                                                <td style="text-align: center; padding-right: 20px;">
                                                    <?php if (strcmp($this->lstEdificio[$i]['estado'], 'Activo') == 0): ?>

                                                        <a href="<?php echo BASE_URL . 'gestionSeccion/eliminarEdificio/-1/' . $this->lstEdificio[$i]['id']; ?>">Desactivar</a>
                                                    <?php else : ?>

                                                        <a href="<?php echo BASE_URL . 'gestionSeccion/eliminarEdificio/1/' . $this->lstEdificio[$i]['id'] ?>">Activar</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center">No hay informaci&oacute;n disponible.</td>
                                        </tr>
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