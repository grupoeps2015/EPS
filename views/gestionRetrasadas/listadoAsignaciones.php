<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Generación de Orden de Pago de Retrasada</h2>
                <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['nombreestudiante']; ?></h3>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['carnet']; ?></h3>
                <?php endif; ?>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionRetrasadas/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>asignacion/indexRetrasada">
                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            A&ntilde;o:
                            <select id="slAnio" name="slAnio" class="form-control input-lg">
                                <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                    <option value="">-- A&ntilde;o --</option>
                                    <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                        <option value="<?php echo $this->lstAnios[$i]['anio']; ?>" <?php if (isset($this->anio) && $this->lstAnios[$i]['anio'] == $this->anio) echo "selected" ?>>
                                            <?php echo $this->lstAnios[$i]['anio']; ?>
                                        </option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="">-- No existen a&ntilde;o registrados --</option>
                                <?php endif; ?>
                            </select><br/>
                        </td>
                        <td>&nbsp;</td>
                        <td style="width:50%">
                            Ciclo:
                            <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                <?php if (isset($this->lstCiclos) && count($this->lstCiclos)): ?>
                                    <option value="">-- Ciclo --</option>
                                    <?php for ($i = 0; $i < count($this->lstCiclos); $i++) : ?>
                                        <option value="<?php echo $this->lstCiclos[$i]['codigo']; ?>" <?php if (isset($this->ciclo) && $this->lstCiclos[$i]['codigo'] == $this->ciclo) echo "selected" ?>>
                                            <?php echo $this->lstCiclos[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="" disabled>-- Ciclo --</option>
                                <?php endif; ?>
                            </select><br/>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Consultar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <input type="hidden" name="hdEnvio" value="1">
                    <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO): ?>
                    <input type="hidden" name="slEstudiantes" value="<?php if (isset($this->estudiante)) echo $this->estudiante ?>">
                    <input type="hidden" name="slCarreras" value="<?php if (isset($this->carrera)) echo $this->carrera ?>">
                    <?php endif; ?>
                </table>
            </form>
        </div>
        <div class="col-md-6 col-md-offset-3">
        <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
        <form id="frAsignaciones" method="post" action="<?php echo BASE_URL; ?>gestionRetrasadas/generarOrdenPago/<?php echo $this->lstAsignaciones[0]['carnet']?>/<?php echo $this->lstAsignaciones[0]['nombreestudiante']?>/<?php echo $this->carrera;?>">
        <div id="divAsignaciones" class="form-group" >
                Seleccione el curso a asignarse examen de retrasada:
                <select id="slCurso" name="slCurso" class="form-control input-lg">
                    <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                        <option value="">-- Curso --</option>
                        <?php for ($i = 0; $i < count($this->lstAsignaciones); $i++) : ?>
                            <option value="<?php echo $this->lstAsignaciones[$i]['codigo'] . '-' . $this->lstAsignaciones[$i]['nombreseccion']; ?>">
                               <?php echo '['.$this->lstAsignaciones[$i]['codigo'] .'] '. $this->lstAsignaciones[$i]['nombre'] . ' - ' . $this->lstAsignaciones[$i]['nombreseccion']; ?>
                            </option>
                        <?php endfor; ?>
                    <?php else : ?>
                        <option value="">-- No existen cursos registrados para este periodo --</option>
                    <?php endif; ?>
                </select>
        </div> 
            <input type="submit" id="btnGenerarOrden" name="btnGenerarOrden" value="Generar orden de pago" class="btn btn-danger btn-lg btn-warning">
            <input type="hidden" name="hdCiclo" id="hdCiclo" value="2">
        </form>     
        <?php else: ?>
        No hay asignaciones disponibles.
        <?php endif; ?>
        </div>
    </div>
</section>
