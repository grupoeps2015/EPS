<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignación de Examen de Retrasada</h2>
                <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['nombreestudiante']; ?></h3>
                    <h3 class="section-heading"><?php echo $this->lstAsignaciones[0]['carnet']; ?></h3>
                <?php endif; ?>
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
            <div style="margin-left: 10%; margin-right: 10%; font-size: 16px;">
                <label style="margin-left: 155px;">
                    1. Seleccione el curso al que desea asignarse una retrasada:
                </label>
                <select id="slCurso" name="slCurso" class="form-control" style="width: 500px; margin-left: 185px;">
                    <?php if (isset($this->lstAsignaciones) && count($this->lstAsignaciones)): ?>
                        <option value="">-- Curso --</option>
                        <?php for ($i = 0; $i < count($this->lstAsignaciones); $i++) : ?>
                            <option value="<?php echo $this->lstAsignaciones[$i]['nombre'] . '-' . $this->lstAsignaciones[$i]['seccion']; ?>">
                               <?php echo $this->lstAsignaciones[$i]['nombre'] . ' - "' . $this->lstAsignaciones[$i]['nombreseccion']. '"'; ?>
                            </option>
                        <?php endfor; ?>
                    <?php else : ?>
                        <option value="">-- No existen cursos registrados para este periodo --</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>   
</section>