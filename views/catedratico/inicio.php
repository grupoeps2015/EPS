<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Bienvenido@ <?php echo " " . $_SESSION["nombre"]; ?></h2>
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

                <!-- Datos Catedratico -->
                <tr class="text-primary">
                    <th style="width: 25%; text-align:center">&nbsp;</th>
                    <th style="width: 25%; text-align:center">Registro Personal</th>
                    <th style="width: 50%; text-align:center">Nombre Completo</th>
                </tr>
                <tr>
                    <td rowspan="6">
                        <img src="<?php echo $_layoutParams['ruta_img']?>profile.JPG" class="img-responsive" alt="">
                    </td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['registro'] ?></td>
                    <td style="text-align:center"><?php echo $this->infoGeneral[0]['nombre'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr1"/></td>
                </tr>

                <!-- Informacion General del Catedratico -->
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
                    <a href="<?php echo BASE_URL . 'gestionUsuario/actualizarUsuario/' . $_SESSION['usuario'];?>">
                        Actualizar informacion
                    </a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-clipboard wow bounceIn text-primary">
                    <a href="#moduloAsignacion">Consultar Notas</a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-pencil-square wow bounceIn text-primary" data-wow-delay=".1s">
                    <a href="<?php echo BASE_URL . 'gestionNotas/cursosXDocente/' . $_SESSION['usuario'] . '/1'?>">
                        Ingreso de Notas
                    </a>
                </i>
            </div>
            <div class="service-box">
                <i class="fa fa-2x fa-users wow bounceIn text-primary">
                    <a href="#moduloAsignacion">Consulta de estudiantes</a>
                </i>
            </div>
        </div>
    </div>
</section>