<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Bienvenid@ <?php echo " " . $_SESSION["nombre"]; ?></h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-6 col-md-offset-1">
            <table class="table-hover" align="center">
                <?php if(isset($this->infoGeneral) && count($this->infoGeneral)): ?>

                <!-- Datos Estudiante -->
                <tr class="text-primary">
                    <th style="width: 25%; text-align:center">&nbsp;</th>
                    <th style="width: 25%; text-align:center">Carnet</th>
                    <th style="width: 50%; text-align:center">Nombre Completo</th>
                </tr>
                <tr>
                    <td rowspan="6">
                        <img src="<?php echo $_layoutParams['ruta_img']?>profile.JPG" class="img-responsive" alt="">
                    </td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['carnet'] ?></td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['nombre'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr1"/></td>
                </tr>

                <!-- Informacion General del Estudiante -->
                <tr class="text-primary">
                    <th colspan="2" style="text-align:center">Informacion general</th>
                </tr>
                <tr>
                    <td class="text-primary" style="width: 20%; text-align:right">Direccion:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['direccion'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary" style="width: 20%; text-align:right">Telefono:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['telefono'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary" style="width: 20%; text-align:right">Nacionalidad:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['pais'] ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><hr class="hr1"/></td>
                </tr>

                <!-- Informacion por Emergencia del Estudiante -->
                <tr class="text-primary">
                    <th>&nbsp;</th>
                    <th colspan="2" style="text-align:center">Informaci&oacute;n en caso de emergencia</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-primary" style="text-align:right">Por emergencias llamar al:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['emergencia'] ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-primary" style="text-align:right">Tipo de sangre:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['sangre'] ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-primary" style="text-align:right">Alergias:&nbsp;</td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['alergias'] ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-primary" style="text-align:right">¿Posee seguro m&eacute;dico?:&nbsp;</td>
                    <td style="text-align:center">
                        <?php if($this->infoGeneral[0]['seguro']){
                                echo "Si";
                              }else{ 
                                echo "No";
                              }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="text-primary" style="text-align:right">Por emergencias trasladarlo a:&nbsp;</td>
                    <td style="text-align:center">
                        <?php echo $this->infoGeneral[0]['hospital'] ?>
                    </td>
                </tr>
                <?php else : ?>
                <tr>
                    <td>- No se encontro informacion asociada al estudiante-</td>
                </tr>
                <?php endif;?>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <div class="service-box">
                <i class="fa fa-2x fa-user wow bounceIn text-primary" data-wow-delay=".1s">
                    <a href="<?php echo BASE_URL . 'gestionUsuario/actualizarUsuario/' . $_SESSION['usuario'];?>">Actualizar informacion</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-book wow bounceIn text-primary">
                    <a href="<?php echo BASE_URL . 'general/seleccionarCarreraEstudiante/asignacion' ?>">Asignaci&oacute;n de cursos</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-search wow bounceIn text-primary">
                    <a href="<?php echo BASE_URL . 'general/seleccionarCarreraEstudiante/asignacion/boletaAsignacion' ?>">Ver cursos asignados</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-clipboard wow bounceIn text-primary">
                    <a href="#moduloAsignacion">Consultar Notas</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-ban wow bounceIn text-primary" data-wow-delay=".1s">
                    <a href="#moduloDesasignacion">Desasignaciones</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-warning wow bounceIn text-primary">
                    <a href="#moduloAsignacion">Repitencia</a>
                </i>
            </div>
        </div>
    </div>
</section>