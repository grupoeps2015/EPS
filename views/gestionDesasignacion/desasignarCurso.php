<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Desasignar Curso</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <?php if (isset($this->asignacion) && count($this->asignacion)): ?>
                                <a href="<?php echo BASE_URL ?>gestionDesasignacion/listadoAsignaciones/<?php echo $this->asignacion[0]['idestudiante']; ?>">
                                    Regresar
                                </a>
                            <?php endif; ?>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <form id="frAsignacion" method="post" action="<?php echo BASE_URL; ?>gestionDesasignacion/desasignarCurso/-1/<?php echo $this->asignacion[0]['asignacion']; ?>/<?php echo $this->asignacion[0]['codigo']; ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <h3>Informacion del Estudiante</h3>
                            <table class="text-primary table-hover" style="margin-left: 16px;">
                                <?php if (isset($this->asignacion) && count($this->asignacion)): ?>

                                    <tr> 
                                        <td>
                                            <label>Carnet: </label>
                                            <?php echo $this->asignacion[0]['carnet']; ?>
                                        </td>
                                        <td><br/></td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Nombre completo:</label>
                                            <?php echo $this->asignacion[0]['nombreestudiante']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>

                                <?php endif; ?>
                            </table>
                            <h3>Informacion General del Curso</h3>
                            <table class="text-primary table-hover" style="margin-left: 16px;">
                                <?php if (isset($this->asignacion) && count($this->asignacion)): ?>

                                    <tr> 
                                        <td>
                                            <label>Codigo del curso: </label>
                                            <?php echo $this->asignacion[0]['codigo']; ?>
                                        </td>
                                        <td><br/></td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Nombre del curso:</label>
                                            <?php echo $this->asignacion[0]['nombre']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Sección:</label>
                                            <?php echo $this->asignacion[0]['seccion']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Descripción:</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <textarea id="descripcion" name="descripcion" rows="4" cols="100"  style="max-height: 100px; max-width: 800px; min-height: 100px; min-width: 800px;" class="form-control input-lg" placeholder="Ingrese la justificación de la desasignación"></textarea><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="submit" id="btnActualizarAsig" name="btnActualizarAsig" value="Desasignar" class="btn btn-danger btn-lg btn-block">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name="hdEst" value="<?php echo $this->asignacion[0]['idestudiante']; ?>">
                    <input type="hidden" name="hdCarnet" value="<?php echo $this->asignacion[0]['carnet']; ?>">
                    <input type="hidden" name="hdCodigo" value="<?php echo $this->asignacion[0]['codigo']; ?>">

                </form>
            </div>
        </div>
    </div>
</section>