<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignaci&oacute;n de retrasadas</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?><?php if(isset($_SESSION["rol"])){if($_SESSION["rol"] == ROL_ESTUDIANTE){echo "estudiante";} else{echo "login";}} ;?>/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container" >
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
          <?php if(isset($this->existePago)&&$this->existePago==2):?> 
            <?php if(isset($this->asignacion)) :?>
        <div class="col-md-6 col-md-offset-3">
            <form id="frm" method="post" action="<?php echo BASE_URL; ?>asignacion/asignarRetrasada">
                <table style="width:100%">
                    <tr>
                        <td style="width:30%">
                            <h4>Listado de cursos: </h4>
                            <br/>
                        </td>
                        <td>&nbsp;</td>
                        <td style="width:70%;">
                            <select id="slCursos" name="slCursos" class="form-control input-lg">
                                <?php if (isset($this->lstAnios) && count($this->lstCursos)): ?>
                                    <option value="">-- Curso --</option>
                                    <?php for ($i = 0; $i < count($this->lstCursos); $i++) : ?>
                                        <option value="<?php echo $this->lstCursos[$i]['asignacion'];?>">
                                            <?php echo "[".$this->lstCursos[$i]['codigo']."] ".$this->lstCursos[$i]['nombre']. ' - ' . $this->lstCursos[$i]['nombreseccion']; ?>
                                        </option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="">-- No existen cursos disponibles --</option>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <input type="submit" id="btnAsignarRetra" name="btnAsignarRetra" value="Asignar examen de retrasada" class="btn btn-danger btn-lg btn-warning">
            </form>
            <form id="frAsignacionCursos" method="post" action="<?php echo BASE_URL; ?>asignacion/asignarRetrasada">
            <table id="tabla" name="tabla" style="width:100%;">
                <thead>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="button" value="Agregar curso" class="clsAgregarFila btn btn-danger btn-lg btn-warning" disabled style="display: none">
                        </td>
                    </tr>
                    <tr>
                        <th><h4><label id="lblCur"></label></h4></th>
                        <th><h4><label id="lblSec"></label></h4></th>
                        <th width="22">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="button" id="btnAsignar" value="Asignar" class="btn btn-danger btn-lg btn-warning" style="display: none;" disabled>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="hdCursos" id="hdCursos">
            <input type="hidden" name="hdCiclo" id="hdCiclo" value="<?php if (isset($this->ciclo)) echo $this->ciclo;?>">
            <input type="hidden" name="hdAnio" id="hdAnio" value="<?php if (isset($this->anio)) echo $this->anio;?>">
            <input type="hidden" name="hdEnvio" value="1">
            <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO): ?>
            <input type="hidden" name="slEstudiantes" value="<?php if (isset($this->estudiante)) echo $this->estudiante ?>">
            <input type="hidden" name="slCarreras" value="<?php if (isset($this->carrera)) echo $this->carrera ?>">
            <?php endif; ?>
            </form>
            </div>
            
            <?php else : ?>
        <div class="col-md-8 col-md-offset-2">
            <center>
            <h4>No hay período de asignación de retrasadas habilitado para el ciclo seleccionado.</h4>
            </center>
        </div>
    <?php endif; ?>
        <?php else : ?>
        <div class="col-md-8 col-md-offset-2">
            <center>
                <h4>No hay &oacute;rdenes de pago canceladas para proseguir.</h4>
            </center>
        </div>
        <?php endif; ?>
        
    </div>
    <br/>
</section>